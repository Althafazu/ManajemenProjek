<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
