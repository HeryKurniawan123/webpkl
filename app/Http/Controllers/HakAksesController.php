<?php

namespace App\Http\Controllers;

use App\Models\PengajuanPkl;
use App\Models\PengajuanUsulan;
use App\Models\UsulanIduka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HakAksesController extends Controller
{
    function hubin(){
        return view('dashboard');
    }
    function siswa(){
        $user = auth()->user();
        $usulanSiswa = UsulanIduka::where('user_id', $user->id)->get();
        $pengajuanSiswa = PengajuanPkl::where('siswa_id', $user->id)->with('iduka')->get();
        $usulanPkl = PengajuanUsulan::with(['iduka'])->where('user_id', $user->id)->get();
        return view('dashboard', compact('usulanSiswa', 'pengajuanSiswa', 'usulanPkl'));
    }
    function iduka(){
        return view('dashboard');
    }
    function kaprog(){
        return view('dashboard');
    }
    function persuratan(){
        return view('dashboard');
    }
    function guru(){
        return view('dashboard');
    }
    function ppkl(){
        return view('dashboard');
    }
    function orangtua(){
        return view('dashboard');
    }
    function psekolah(){
        return view('dashboard');
    }
    public function index(){
        return view('login');
    }
    public function login(Request $request){
            $request->validate([
                'nip' => 'required',
                'password' => 'required',
            ], [
                'nip.required' => 'nip Wajib Diisi',
                'password.required'=>'Password Wajib Diisi',
            ]);
    
            $infoLogin =[
                'nip' => $request->nip,
                'password' => $request->password,
            ];
    
            if(Auth::attempt($infoLogin)){
                if(Auth::user()->role == 'hubin'){
                    return redirect()->route( 'hubin.dashboard' );
                }
                elseif(Auth::user()->role == 'siswa'){
                    return redirect()->route( 'siswa.dashboard' );
                }
                elseif(Auth::user()->role == 'kaprog'){
                    return redirect()->route( 'kaprog.dashboard' );
                }
                elseif(Auth::user()->role == 'guru'){
                    return redirect()->route( 'guru.dashboard' );
                }
                elseif(Auth::user()->role == 'ppkl'){
                    return redirect()->route( 'ppkl.dashboard' );
                }
                elseif(Auth::user()->role == 'psekolah'){
                    return redirect()->route( 'psekolah.dashboard' );
                }
                elseif(Auth::user()->role == 'iduka'){
                    return redirect()->route( 'iduka.dashboard' );
                }
                elseif(Auth::user()->role == 'orangtua'){
                    return redirect()->route( 'orangtua.dashboard' );
                }
                elseif(Auth::user()->role == 'persuratan'){
                    return redirect()->route( 'persuratan.dashboard' );
                }
            }
            else {
                return redirect('/login')->withErrors('Username dan Password yang dimasukkan tidak sesuai')->withInput();
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('');
    }
}
