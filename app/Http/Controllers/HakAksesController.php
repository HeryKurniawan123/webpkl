<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HakAksesController extends Controller
{
    function hubin(){
        return view('hubin.index');
    }
    function siswa(){
        return view('siswa.index');
    }
    function iduka(){
        return view('iduka.index');
    }
    function kaprog(){
        return view('kaprog.index');
    }
    function persuratan(){
        return view('persuratan.index');
    }
    function guru(){
        return view('guru.index');
    }
    function ppkl(){
        return view('ppkl.index');
    }
    function orangtua(){
        return view('orangtua.index');
    }
    function psekolah(){
        return view('psekolah.index');
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
                    return redirect()->route( 'hubin' );
                }
                elseif(Auth::user()->role == 'siswa'){
                    return redirect()->route( 'siswa' );
                }
                elseif(Auth::user()->role == 'kaprog'){
                    return redirect()->route( 'kaprog' );
                }
                elseif(Auth::user()->role == 'guru'){
                    return redirect()->route( 'guru' );
                }
                elseif(Auth::user()->role == 'ppkl'){
                    return redirect()->route( 'ppkl' );
                }
                elseif(Auth::user()->role == 'psekolah'){
                    return redirect()->route( 'psekolah' );
                }
                elseif(Auth::user()->role == 'iduka'){
                    return redirect()->route( 'iduka' );
                }
                elseif(Auth::user()->role == 'orangtua'){
                    return redirect()->route( 'orangtua' );
                }
                elseif(Auth::user()->role == 'persuratan'){
                    return redirect()->route( 'persuratan' );
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
