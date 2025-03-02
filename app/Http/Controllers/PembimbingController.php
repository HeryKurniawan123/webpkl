<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PembimbingController extends Controller
{
    public function create()
    {
        $pembimbing = Auth::user()->pembimbing ?? new Pembimbing();
        $iduka = User::with('iduka')->where('id', Auth::id())->first();
        return view('iduka.pembimbing.form', compact('pembimbing', 'iduka'));
    }
    

    public function store(Request $request)
    {
        $pembimbing = Auth::user()->pembimbing;

        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|unique:users,nip,' . ($pembimbing->id ?? 'null') . ',id',
            'no_hp' => 'required|string|max:15|unique:pembimbingpkl,no_hp,' . ($pembimbing->id ?? 'null') . ',id',
            'password' => 'required|string|min:6',
        ]);

         User::create([
            'name' => $request->name,
            'nip' => $request->nip, 
            'password' => Hash::make($request->password),
            'role' => 'ppkl', 
        ]);

        $data = array_merge(
            $request->all(),
            ['user_id' => Auth::id()]
        );

        if (!$pembimbing) {
            $pembimbing = Pembimbing::create($data);
        } else {
            $pembimbing->update($data);
        }

        return redirect()->route('iduka.pembimbing.create')
        ->with('success', 'Data pembimbing berhasil disimpan.')
        ->withInput(); 
    }

    public function show()
    {
        $pembimbing = Auth::user()->pembimbing;
        return view('iduka.pembimbing.detail', compact('pembimbing'));
    }

    public function update(Request $request, $id)
    {
        // Ambil data pembimbing berdasarkan ID
        $pembimbing = Pembimbing::findOrFail($id);
        $user = $pembimbing->user;
    
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => ['required', 'string', 'max:255',
                function ($attribute, $value, $fail) use ($user) {
                    if ($value !== $user->nip && User::where('nip', $value)->where('id', '!=', $user->id)->exists()) {
                        $fail('NIP sudah digunakan.');
                    }
                }
            ],
            'no_hp' => ['required', 'string', 'max:15',
                function ($attribute, $value, $fail) use ($pembimbing) {
                    if ($value !== $pembimbing->no_hp && Pembimbing::where('no_hp', $value)->where('id', '!=', $pembimbing->id)->exists()) {
                        $fail('Nomor HP sudah digunakan.');
                    }
                }
            ],
            'password' => 'nullable|string|min:6',
        ]);
    
            DB::transaction(function () use ($request, $pembimbing, $user) {
            // Update data Pembimbing
            $pembimbing->update([
                'name' => $request->name,
                'nip' => $request->nip,
                'no_hp' => $request->no_hp,
            ]);
    
            // Update data User terkait
            $user->update([
                'name' => $request->name,
                'nip' => $request->nip,
                'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            ]);
        });
    
        return redirect()->back()->with('success', 'Data Pembimbing berhasil diperbarui.');
    }
    
    
}
