<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus = Buku::latest()->paginate(10);
        $totalBuku = Buku::count();
        return view('admin.buku.index', compact('bukus', 'totalBuku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi (Hapus kode_buku dari validasi karena diisi sistem)
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string',
            'penerbit' => 'required|string',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'jenis_buku' => 'required|in:Fiksi,Non-Fiksi,Pelajaran,Referensi,Jurnal,Majalah',
        ]);

        // 2. Siapkan data
        $data = $request->all();

        // 3. Generate Kode berdasarkan Jenis Buku yang dipilih
        $data['kode_buku'] = Buku::createCode($request->jenis_buku);

        // 4. Simpan
        Buku::create($data);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan dengan Kode: ' . $data['kode_buku']);
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
        $buku = Buku::findOrFail($id);
        return view('admin.buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            // Kode buku tidak boleh diubah
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string',
            'penerbit' => 'required|string',
            'tahun_terbit' => 'required|digits:4',
            'jenis_buku' => 'required|in:Fiksi,Non-Fiksi,Pelajaran,Referensi,Jurnal,Majalah',
            'status' => 'required|in:Tersedia,Dipinjam,Hilang,Rusak',
        ]);

        $buku->update($request->all());

        return redirect()->route('admin.buku.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
