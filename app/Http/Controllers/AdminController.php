<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    function index(){
        return view("dashboard.dashboard-admin");

echo "<a href='logout'>log out</a>";
    }
    function dosen(){
        echo "Welcome Dosen";
        echo "<h1>". Auth::user()->name."</h1>";

echo "<a href='/logout'>log out</a>";
    }
    function mahasiswa(){
        return view("dashboard.dashboard-proyek");

    }

}