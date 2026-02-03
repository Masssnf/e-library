<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {

        // Total Anggota
        $totalAnggota = Anggota::count();
    
        return view('admin.dashboard',compact('totalAnggota'));
    }

    public function users()
    {
        // Logika untuk menampilkan daftar pengguna
        return view('admin.users');
    }
}
