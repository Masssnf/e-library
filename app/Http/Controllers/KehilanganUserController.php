<?php

namespace App\Http\Controllers;

use App\Models\Kehilangan;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KehilanganUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        if (!$user->anggota) {
            return back()->with('error', 'Data anggota tidak ditemukan.');
        }

        // Ambil transaksi yang statusnya 'Dipinjam' atau 'Telat'
        $pinjamanAktif = Peminjaman::with('buku')
            ->where('anggota_id', $user->anggota->id)
            ->whereIn('status', ['Dipinjam', 'Telat'])
            ->get();

        return view('mahasiswa.kehilangan.create', compact('pinjamanAktif'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:datapeminjaman,id',
            'keterangan' => 'required|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        Kehilangan::create([
            'kode_kehilangan' => Kehilangan::createCode(),
            'peminjaman_id' => $peminjaman->id,
            'anggota_id' => $peminjaman->anggota_id,
            'buku_id' => $peminjaman->buku_id,
            'tanggal_laporan' => Carbon::now(),
            'keterangan' => $request->keterangan,
            'status' => 'Diajukan',
        ]);

        return redirect()->route('mahasiswa.peminjaman.index')
            ->with('success', 'Laporan kehilangan berhasil diajukan. Tunggu konfirmasi admin mengenai denda.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
