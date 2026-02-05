<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {

        // Total Anggota
        $totalAnggota = Anggota::count();
        $totalBuku = Buku::count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
    
        return view('admin.dashboard',compact('totalAnggota','totalBuku','sedangDipinjam'));
    }

    public function users()
    {
        // Logika untuk menampilkan daftar pengguna
        return view('admin.users');
    }
}
