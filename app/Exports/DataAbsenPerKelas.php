<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataAbsenPerKelas implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $start;
    protected $end;
    protected $konkeId;
    protected $kelasId;
    protected $guruId;
    protected $konkeName;
    protected $kelasName;

    public function __construct($start = null, $end = null, $konkeId = null, $kelasId = null, $guruId = null, $konkeName = null, $kelasName = null)
    {
        $this->start = $start;
        $this->end = $end;
        $this->konkeId = $konkeId;
        $this->kelasId = $kelasId;
        $this->guruId = $guruId;
        $this->konkeName = $konkeName;
        $this->kelasName = $kelasName;
    }

    public function collection()
    {
        // gather students constrained by provided filters and role (guruId)
        $userQuery = User::where('role', 'siswa')
            ->when($this->konkeId, function ($q) {
                $q->where('konke_id', $this->konkeId);
            })
            ->when($this->kelasId, function ($q) {
                $q->where('kelas_id', $this->kelasId);
            })
            ->when($this->guruId, function ($q) {
                $q->where('pembimbing_id', $this->guruId);
            });

        $students = $userQuery->with('kelas:id,name_kelas')->select(['id', 'name', 'nip', 'kelas_id'])->get();

        $studentIds = $students->pluck('id')->all();

        // build aggregation for these students
        $aggQuery = Absensi::query();
        if ($this->start && $this->end) {
            $aggQuery->whereBetween('tanggal', [$this->start, $this->end]);
        }
        if (!empty($studentIds)) {
            $aggQuery->whereIn('user_id', $studentIds);
        } else {
            // no students -> empty collection
            return collect([]);
        }

        $counts = $aggQuery->select([
            'absensi.user_id',
            DB::raw("SUM(CASE WHEN (absensi.status IN ('tepat_waktu','terlambat','hadir') OR (absensi.jenis_dinas IS NOT NULL AND absensi.status_dinas='disetujui')) THEN 1 ELSE 0 END) as H"),
            DB::raw("SUM(CASE WHEN absensi.status='izin' AND absensi.jenis_izin LIKE '%sakit%' THEN 1 ELSE 0 END) as S"),
            DB::raw("SUM(CASE WHEN absensi.status='izin' AND absensi.jenis_izin NOT LIKE '%sakit%' THEN 1 ELSE 0 END) as I"),
            DB::raw("SUM(CASE WHEN absensi.status='alpha' OR absensi.status='absen' THEN 1 ELSE 0 END) as A"),
        ])->groupBy('absensi.user_id')->get()->keyBy('user_id');

        // map students to rows
        $rows = $students->map(function ($s) use ($counts) {
            $c = $counts->get($s->id) ?? (object)['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0];
            return [
                'Nama Siswa' => $s->name ?? '-',
                'NIS' => $s->nip ?? '-',
                'Kelas' => optional($s->kelas)->name_kelas ?? '-',
                'Hadir (H)' => $c->H,
                'Sakit (S)' => $c->S,
                'Izin (I)' => $c->I,
                'Alpha (A)' => $c->A,
                'Total' => ($c->H + $c->S + $c->I + $c->A),
            ];
        });

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'NIS',
            'Kelas',
            'Hadir (H)',
            'Sakit (S)',
            'Izin (I)',
            'Alpha (A)',
            'Total',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // build title and subtitle
                $title = 'Rekapan Absensi';
                if ($this->konkeName) {
                    $title .= ' - ' . $this->konkeName;
                }
                if ($this->kelasName) {
                    $title .= ' / ' . $this->kelasName;
                }

                $period = '';
                if ($this->start && $this->end) {
                    $period = 'Periode: ' . $this->start . ' s.d ' . $this->end;
                } elseif ($this->start) {
                    $period = 'Tanggal: ' . $this->start;
                }

                // insert two rows at top so headings shift down
                $sheet->insertNewRowBefore(1, 2);

                // write title and period
                $sheet->setCellValue('A1', $title);
                $sheet->setCellValue('A2', $period);

                // merge across columns A..H (8 columns)
                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');

                // style
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A2')->getFont()->setBold(false)->setSize(11);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }
        ];
    }
}
