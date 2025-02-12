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
            'name' => 'required',
            'password' => 'required'
        ],[
            'name.required' =>'Nama wajib di isi',
            'password.required' =>'Password wajib di isi',
        ]);
    $infologin =[
        'name' => $request->name,
        'password' => $request->password,
    ];

    if(Auth::attempt($infologin)){
        if(Auth::user()->role == 'ROL23'){
            return redirect('admin/mahasiswa');
        }elseif (Auth::user()->role == 'ROL25'){
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
