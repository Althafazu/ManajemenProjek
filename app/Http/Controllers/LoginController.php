<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function index(){
        return view("login.index");
    }

    function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' =>'Nama wajib di isi',
            'password.required' =>'Password wajib di isi',
        ]);

        $infologin = [
            'usr_name' => $request->username,
            'password' => $request->password,
        ];

        if(Auth::attempt($infologin)){
            // Debug point untuk cek role dan session
            dd([
                'session_data' => session()->all(),
                'auth_data' => [
                    'user' => Auth::user(),
                    'role_id' => Auth::user()->rol_id,
                    'username' => Auth::user()->usr_name,
                    'should_redirect_to' => Auth::user()->rol_id == 'ROL23' ? 'admin/mahasiswa' : 'admin/dosen'
                ]
            ]);

            if(Auth::user()->rol_id == 'ROL23'){
                return redirect('admin/mahasiswa');
            }elseif (Auth::user()->rol_id == 'ROL25'){
                return redirect('admin/dosen');
            }
        }else{
            dd([
                'auth_failed' => true,
                'attempted_username' => $request->usr_name,
                'errors' => 'Username and Password salah'
            ]);
            return redirect('')->withErrors('Username and Password salah')->withInput();
        }
    }

    function logout(){
        Auth::logout();
        return redirect('');
    }
}
