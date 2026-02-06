<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Mulai Query dengan Eager Loading
        $query = Peminjaman::with(['anggota', 'buku']);

        // 2. Filter Pencarian (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                // Cari berdasarkan Kode Peminjaman
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                    // Atau cari berdasarkan Nama Anggota
                    ->orWhereHas('anggota', function ($qa) use ($search) {
                        $qa->where('nama_anggota', 'like', "%{$search}%")
                            ->orWhere('kode_anggota', 'like', "%{$search}%");
                    })
                    // Atau cari berdasarkan Judul Buku
                    ->orWhereHas('buku', function ($qb) use ($search) {
                        $qb->where('judul', 'like', "%{$search}%")
                            ->orWhere('kode_buku', 'like', "%{$search}%");
                    });
            });
        }

        // 3. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Ambil Data (Pagination + Append Query String)
        $peminjamans = $query->latest()->paginate(10)->appends($request->all());

        // 5. Hitung Total Data (Statistik)
        $totalPeminjaman = Peminjaman::count();

        return view('admin.peminjaman.index', compact('peminjamans', 'totalPeminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Generate Kode Peminjaman
        $kodeOtomatis = Peminjaman::createCode();

        // Ambil data untuk dropdown
        $anggotas = Anggota::orderBy('nama_anggota')->get();
        // Hanya ambil buku yang stoknya > 0
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul')->get();

        return view('admin.peminjaman.create', compact('anggotas', 'bukus', 'kodeOtomatis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Pastikan unique mengecek ke tabel 'datapeminjaman'
            'kode_peminjaman' => 'required|unique:datapeminjaman,kode_peminjaman',
            'anggota_id' => 'required|exists:dataanggota,id',
            'buku_id' => 'required|exists:databuku,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        // 1. Cek Stok Buku lagi (untuk keamanan ganda)
        $buku = Buku::findOrFail($request->buku_id);
        if ($buku->stok < 1) {
            return back()->with('error', 'Stok buku habis!');
        }

        // 2. Hitung Tanggal Wajib Kembali (+7 Hari)
        $tanggalPinjam = Carbon::parse($request->tanggal_pinjam);
        $tanggalWajibKembali = $tanggalPinjam->copy()->addDays(7);

        // 3. Simpan Transaksi
        Peminjaman::create([
            'kode_peminjaman' => $request->kode_peminjaman,
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_wajib_kembali' => $tanggalWajibKembali,
            'status' => 'Dipinjam',
        ]);

        // 4. KURANGI STOK BUKU
        $buku->decrement('stok');

        return redirect()->route('admin.peminjaman.index')->with('success', 'Transaksi berhasil. Kode: ' . $request->kode_peminjaman);
    }

    public function complete($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'Dipinjam') {
            return back()->with('error', 'Buku sudah dikembalikan sebelumnya.');
        }

        // Update status dan tanggal kembali
        $peminjaman->update([
            'status' => 'Dikembalikan',
            'tanggal_pengembalian' => Carbon::now(),
        ]);

        // TAMBAH STOK BUKU KEMBALI
        $buku = Buku::findOrFail($peminjaman->buku_id);
        $buku->increment('stok');

        return redirect()->route('admin.peminjaman.index')->with('success', 'Buku berhasil dikembalikan. Stok bertambah.');
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

    // Method untuk Menyetujui Pengajuan
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'Menunggu Konfirmasi') {
            return back()->with('error', 'Status transaksi tidak valid.');
        }

        // Set Tanggal Pinjam = HARI INI
        // Set Jatuh Tempo = HARI INI + 7
        $peminjaman->update([
            'status' => 'Dipinjam',
            'tanggal_pinjam' => Carbon::now(),
            'tanggal_wajib_kembali' => Carbon::now()->addDays(7),
        ]);

        return back()->with('success', 'Peminjaman disetujui. Waktu hitung mundur dimulai.');
    }

    // Method untuk Menolak Pengajuan
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'Menunggu Konfirmasi') {
            return back()->with('error', 'Status transaksi tidak valid.');
        }

        // Kembalikan Stok Buku
        $peminjaman->buku->increment('stok');

        // Ubah status jadi Ditolak (atau bisa di-delete permanen)
        $peminjaman->update(['status' => 'Ditolak']);

        return back()->with('success', 'Pengajuan ditolak. Stok buku dikembalikan.');
    }
}
