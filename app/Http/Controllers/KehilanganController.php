<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kehilangan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class KehilanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kehilangans = Kehilangan::with(['anggota', 'buku'])->latest()->paginate(10);
        return view('admin.kehilangan.index', compact('kehilangans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $kehilangan = Kehilangan::findOrFail($id);
        return view('admin.kehilangan.edit', compact('kehilangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kehilangan = Kehilangan::findOrFail($id);

        $request->validate([
            'denda' => 'required|numeric|min:0',
            'status' => 'required|in:Diajukan,Konfirmasi,Selesai,Ditolak',
        ]);

        // Jika status diubah jadi Selesai (Denda lunas)
        if ($request->status == 'Selesai' && $kehilangan->status != 'Selesai') {
            // 1. Update Status Buku jadi 'Hilang' atau 'Rusak' di tabel master buku
            $buku = Buku::findOrFail($kehilangan->buku_id);
            // Opsional: $buku->update(['status' => 'Hilang']); 
            // Note: Stok sudah berkurang saat dipinjam, jadi tidak perlu dikurangi lagi.
            // Tapi status buku mungkin perlu ditandai agar admin tahu buku fisik berkurang.

            // 2. Update Status Peminjaman jadi 'Dikembalikan' (Case closed secara administrasi)
            $peminjaman = Peminjaman::findOrFail($kehilangan->peminjaman_id);
            $peminjaman->update(['status' => 'Dikembalikan']);
        }

        $kehilangan->update([
            'denda' => $request->denda,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.kehilangan.index')
            ->with('success', 'Data kehilangan diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kehilangan = Kehilangan::findOrFail($id);
        $kehilangan->delete();
        return redirect()->route('admin.kehilangan.index')->with('success', 'Data dihapus.');
    }
}
