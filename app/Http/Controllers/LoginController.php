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
            'usr_name' => 'required',
            'usr_password' => 'required'
        ],[
            'usr_name.required' =>'Nama wajib di isi',
            'usr_password.required' =>'Password wajib di isi',
        ]);

        $infologin = [
            'usr_name' => $request->usr_name,
            'usr_password' => $request->usr_password,
        ];

        if(Auth::attempt($infologin)){
            if(Auth::user()->rol_id == 'ROL23'){
                return redirect('admin/mahasiswa');
            }elseif (Auth::user()->rol_id == 'ROL25'){
                return redirect('admin/dosen');
            }
        }else{
            return redirect('')->withErrors('Username and Password salah')->withInput();
        }
    }

    function logout(){
        Auth::logout();
        return redirect('');
    }
}
