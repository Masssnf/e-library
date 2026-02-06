<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanUserController extends Controller
{
    // Halaman Katalog Buku (Untuk User memilih)
    public function katalog(Request $request)
    {
        $query = Buku::where('stok', '>', 0); // Hanya buku yang ada stok

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $bukus = $query->paginate(12);
        return view('mahasiswa.buku.index', compact('bukus'));
    }

    // Proses Pengajuan Pinjaman
    public function ajukan(Request $request, $buku_id)
    {
        $user = Auth::user();
        
        // 1. Cek apakah User ini sudah terhubung dengan Data Anggota?
        if (!$user->anggota) {
            return back()->with('error', 'Akun Anda belum terhubung dengan Data Anggota. Hubungi Admin.');
        }

        // 2. Cek Stok Buku
        $buku = Buku::findOrFail($buku_id);
        if ($buku->stok < 1) {
            return back()->with('error', 'Stok buku habis.');
        }

        // 3. Cek apakah sedang meminjam buku yang sama (pending/dipinjam)
        $sedangPinjam = Peminjaman::where('anggota_id', $user->anggota->id)
            ->where('buku_id', $buku_id)
            ->whereIn('status', ['Menunggu Konfirmasi', 'Dipinjam'])
            ->exists();

        if ($sedangPinjam) {
            return back()->with('error', 'Anda sedang meminjam atau mengajukan buku ini.');
        }

        // 4. Buat Kode Transaksi
        $kode = Peminjaman::createCode();

        // 5. Simpan (Status Default: Menunggu Konfirmasi)
        // Tanggal dikosongkan dulu, nanti Admin yang set saat Approve
        Peminjaman::create([
            'kode_peminjaman' => $kode,
            'anggota_id' => $user->anggota->id,
            'buku_id' => $buku->id,
            'status' => 'Menunggu Konfirmasi',
        ]);

        // 6. Kurangi Stok (Booking)
        $buku->decrement('stok');

        return redirect()->route('mahasiswa.peminjaman.index')
            ->with('success', 'Pengajuan berhasil! Tunggu konfirmasi Admin.');
    }

    // Halaman Riwayat Peminjaman Saya
    public function riwayat()
    {
        $user = Auth::user();
        
        if (!$user->anggota) {
            return redirect()->route('dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        $peminjamans = Peminjaman::with('buku')
            ->where('anggota_id', $user->anggota->id)
            ->latest()
            ->paginate(10);

        return view('mahasiswa.peminjaman.index', compact('peminjamans'));
    }
}
