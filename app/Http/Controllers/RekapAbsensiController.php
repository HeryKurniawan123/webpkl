<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataAbsenPerKelas;

class RekapAbsensiController extends Controller
{    // Endpoint untuk filter dropdown
    public function filterOptions(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            // called from non-web context (debug); treat as superuser
            $role = 'hubin';
        } else {
            $role = $user->role;
        }
        // debug logging of incoming filter parameters
        \Log::debug('filterOptions called', ['konke_id' => $request->konke_id, 'kelas_id' => $request->kelas_id, 'role' => $role]);

        // determine the identifier used in pembimbing_id column.
        // normally students point to the gurus.id value, but in some places
        // only users.id (teacher account) is stored because there is no
        // separate guru row.  we support both by falling back to the user id.
        $guruId = null;
        if ($user && $role === 'guru') {
            $guruId = optional($user->guru)->id ?: $user->id;
            \Log::debug('filterOptions guru id lookup', ['user_id' => $user->id, 'guru_table_id' => optional($user->guru)->id, 'effective_id' => $guruId]);
        }

        // prepare base queries
        $jurusanQuery = \App\Models\Konke::query();
        $kelasQuery   = \App\Models\Kelas::query();
        $siswaQuery   = \App\Models\User::where('role', 'siswa');

        // apply role restrictions
        if (in_array($role, ['hubin', 'kepsek'])) {
            // no additional constraints
        } elseif ($role === 'kaprog') {
            $jurusanQuery->where('id', $user->konke_id);
            $kelasQuery->where('konke_id', $user->konke_id);
            $siswaQuery->where('konke_id', $user->konke_id);
        } elseif ($role === 'guru') {
            // use the computed identifier to match against pembimbing_id
            if ($guruId) {
                $jurusanQuery->whereHas('kelas.siswa', function ($q) use ($guruId) {
                    $q->where('pembimbing_id', $guruId);
                });
                $kelasQuery->whereHas('siswa', function ($q) use ($guruId) {
                    $q->where('pembimbing_id', $guruId);
                });
                $siswaQuery->where('pembimbing_id', $guruId);
            } else {
                // shouldn't happen, but just in case
                $siswaQuery->whereRaw('1=0');
            }
        }

        // additional filters from request (used for dependent dropdowns)
        if ($request->filled('konke_id')) {
            $kelasQuery->where('konke_id', $request->konke_id);
            $siswaQuery->where('konke_id', $request->konke_id);
        }
        if ($request->filled('kelas_id')) {
            $siswaQuery->where('kelas_id', $request->kelas_id);
        }

        $jurusan = $jurusanQuery->select('id', 'name_konke')->get();
        $kelas   = $kelasQuery->select('id', 'name_kelas', 'konke_id')->get();
        $siswa   = $siswaQuery->select('id', 'name', 'kelas_id', 'konke_id')->get();

        return response()->json([
            'jurusan' => $jurusan,
            'kelas' => $kelas,
            'siswa' => $siswa
        ]);
    }

    // Form filter & tampilan awal
    public function index(Request $request)
    {
        return view('rekap_absensi.index');
    }

    // Endpoint data (AJAX/pagination)
    public function data(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        // determine guru id same as filterOptions
        $guruId = null;
        if ($user && $role === 'guru') {
            $guruId = optional($user->guru)->id ?: $user->id;
            \Log::debug('data method guru id lookup', ['user_id'=>$user->id,'effective_id'=>$guruId]);
        }
        // always load related user data and kelas so front-end can display class name
        $query = Absensi::with(['user.dataPribadi', 'user.kelas', 'iduka']);
        // ensure the nis stored in data_pribadis.nip is available when serializing the user


        // Filter tanggal wajib
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        if ($start && $end) {
            $query->whereBetween('tanggal', [$start, $end]);
        } else {
            // previous behaviour required dates for all users; allow guru (pembimbing)
            // to fetch without specifying a range so table can load automatically
            if (!in_array($role, ['guru'])) {
                return response()->json([
                    'error' => 'Tanggal awal dan akhir wajib diisi.'
                ], 422);
            }
            // else skip date filter entirely
        }

        // Filter by role
        if (in_array($role, ['hubin', 'kepsek'])) {
            // akses semua data
        } elseif ($role === 'kaprog') {
            // hanya siswa jurusan (konke_id) kaprog
            $konke = $user->konke_id ?? null;
            if ($konke) {
                $query->whereHas('user', function ($q) use ($konke) {
                    $q->where('konke_id', $konke);
                });
            } else {
                $query->whereRaw('1=0'); // tidak ada jurusan/konke
            }
        } elseif ($role === 'guru') {
            // hanya siswa yang dibimbing -- again use guru table id
            if ($guruId) {
                $query->whereHas('user', function ($q) use ($guruId) {
                    $q->where('pembimbing_id', $guruId);
                });
            } else {
                $query->whereRaw('1=0');
            }
        } else {
            return response()->json(['error' => 'Akses tidak diizinkan'], 403);
        }

        // additional filters from request
        if ($request->filled('konke_id')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('konke_id', $request->konke_id);
            });
        }
        if ($request->filled('kelas_id')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }
        if ($request->filled('siswa_id')) {
            $query->where('user_id', $request->siswa_id);
        }

        // handle guru separately to avoid huge memory usage and to aggregate counts
        if ($role === 'guru') {
            // get all supervised students (nip column renamed to nis for response)
            $students = collect();
            if ($guruId) {
                $students = \App\Models\User::where('role', 'siswa')
                    ->where('pembimbing_id', $guruId)
                    ->with('kelas:id,name_kelas')
                    ->select(['id', 'name', 'nip as nis', 'kelas_id'])
                    ->get();
            }
            \Log::debug('guru students fetched', ['guru_id' => $guruId, 'count' => $students->count()]);

            // build base absensi query for guru students
            $aggQuery = \App\Models\Absensi::query();
            if ($guruId) {
                $aggQuery->whereHas('user', function($q) use ($guruId) {
                    $q->where('pembimbing_id', $guruId);
                });
            } else {
                // no guru id -> no rows
                $aggQuery->whereRaw('1=0');
            }

            if ($start && $end) {
                $aggQuery->whereBetween('tanggal', [$start, $end]);
            }
            if ($request->filled('konke_id')) {
                $aggQuery->whereHas('user', function($q) use ($request) {
                    $q->where('konke_id', $request->konke_id);
                });
            }
            if ($request->filled('kelas_id')) {
                $aggQuery->whereHas('user', function($q) use ($request) {
                    $q->where('kelas_id', $request->kelas_id);
                });
            }

            // explicitly select from absensi table to avoid MySQL strict mode issues
            $counts = $aggQuery->select([
                'absensi.user_id',
                DB::raw("SUM(CASE WHEN (absensi.status IN ('tepat_waktu','terlambat','hadir') OR (absensi.jenis_dinas IS NOT NULL AND absensi.status_dinas='disetujui')) THEN 1 ELSE 0 END) as H"),
                DB::raw("SUM(CASE WHEN absensi.status='izin' AND absensi.jenis_izin LIKE '%sakit%' THEN 1 ELSE 0 END) as S"),
                DB::raw("SUM(CASE WHEN absensi.status='izin' AND absensi.jenis_izin NOT LIKE '%sakit%' THEN 1 ELSE 0 END) as I"),
                DB::raw("SUM(CASE WHEN absensi.status='alpha' OR absensi.status='absen' THEN 1 ELSE 0 END) as A"),
            ])->groupBy('absensi.user_id')->get()->keyBy('user_id');

            \Log::debug('guru aggregation results', ['guru_id' => $guruId, 'counts_data' => $counts->toArray()]);

            // build row objects
            $rows = collect();
            foreach ($students as $s) {
                $cnt = $counts->get($s->id) ?? (object)['H'=>0,'S'=>0,'I'=>0,'A'=>0];
                $rows->push((object)[
                    'user' => $s,
                    'counts' => $cnt
                ]);
            }

            return response()->json(['data' => $rows, 'students' => $students]);
        }

        // Pagination for non-guru (normal behavior)
        $perPage = $request->input('per_page', 25);
        $absensi = $query->orderBy('tanggal', 'desc')->paginate($perPage);
        return response()->json($absensi);
    }

    // Export aggregated absensi per kelas (Excel)
    public function exportPerKelas(Request $request)
    {
        $user = Auth::user();
        $role = $user->role ?? null;

        // determine guru id same as other methods
        $guruId = null;
        if ($user && $role === 'guru') {
            $guruId = optional($user->guru)->id ?: $user->id;
        }

        $start = $request->input('start_date');
        $end = $request->input('end_date');

        if (!($start && $end) && $role !== 'guru') {
            return response()->json(['error' => 'Tanggal awal dan akhir wajib diisi untuk ekspor.'], 422);
        }

        // role-based constraints: for kaprog use user's konke_id; for guru limit to pembimbing; hubin/kepsek no restriction
        $konkeId = null;
        $kelasId = $request->input('kelas_id');
        if ($role === 'kaprog') {
            $konkeId = $user->konke_id ?? null;
        }

        // resolve readable names for filename and title
        $konkeName = null;
        $kelasName = null;

        if ($role === 'guru') {
            // for guru, use "Bimbingan - {GuruName}" as konkeName so title shows guru's name
            $gurName = $user->name ?? 'Guru';
            $konkeName = 'Bimbingan - ' . $gurName;
            // build filename: rekapabsen_bimbingan_{guru_name}_{dates}...
            $parts = ['rekapabsen_bimbingan'];
            $parts[] = preg_replace('/[^A-Za-z0-9_\-]/', '_', str_replace(' ', '_', strtolower($gurName)));
            if ($start) $parts[] = $start;
            if ($end) $parts[] = $end;
            $fileName = implode('_', $parts) . '_' . date('Ymd_His') . '.xlsx';
        } else {
            // for non-guru (kaprog, hubin, kepsek): use jurusan/kelas
            if ($konkeId) {
                $konke = \App\Models\Konke::find($konkeId);
                $konkeName = $konke ? ($konke->singkatan ?? $konke->name_konke) : null;
            } elseif ($user && isset($user->konke_id)) {
                $k = \App\Models\Konke::find($user->konke_id);
                $konkeName = $k ? ($k->singkatan ?? $k->name_konke) : null;
            }
            if ($kelasId) {
                $kls = \App\Models\Kelas::find($kelasId);
                $kelasName = $kls ? $kls->name_kelas : null;
            }

            // build a friendly filename: rekap_absensi_{konke}_{kelas}_{start}_{end}.xlsx
            $parts = ['rekap_absensi'];
            if ($konkeName) $parts[] = preg_replace('/[^A-Za-z0-9_\-]/', '_', str_replace(' ', '_', strtolower($konkeName)));
            if ($kelasName) $parts[] = preg_replace('/[^A-Za-z0-9_\-]/', '_', str_replace(' ', '_', strtolower($kelasName)));
            if ($start) $parts[] = $start;
            if ($end) $parts[] = $end;
            $fileName = implode('_', $parts) . '_' . date('Ymd_His') . '.xlsx';
        }

        $export = new DataAbsenPerKelas($start, $end, $konkeId, $kelasId, $guruId, $konkeName, $kelasName);
        return Excel::download($export, $fileName);
    }
}
