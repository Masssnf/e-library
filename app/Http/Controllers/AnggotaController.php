<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data terbaru dengan pagination 10 per halaman
        $anggotas = Anggota::latest()->paginate(10);

        $totalAnggota = Anggota::count();

        return view('admin.anggota.index', compact('anggotas','totalAnggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // kode anggota otomatis
        $kode_anggota = Anggota::createCode();

        return view('admin.anggota.create', compact('kode_anggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            // Kembalikan validasi required & unique karena data dikirim dari form
            'kode_anggota' => 'required|unique:dataanggota,kode_anggota', 
            'nama_anggota' => 'required|string|max:255',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat'       => 'required|string',
            'no_telepon'   => 'required|string|max:15',
            'jenis_anggota'=> 'required|in:Karyawan,Dosen,Mahasiswa',
        ]);

        // 2. Simpan data (Langsung gunakan $request->all() karena kode_anggota sudah termasuk)
        Anggota::create($request->all());

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
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
        $anggota = Anggota::findOrFail($id);
        return view('admin.anggota.edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            // Unique tapi abaikan ID saat ini
            'kode_anggota' => 'required|unique:dataanggota,kode_anggota,' . $anggota->id,
            'nama_anggota' => 'required|string|max:255',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat'       => 'required|string',
            'no_telepon'   => 'required|string|max:15',
            'jenis_anggota' => 'required|in:Karyawan,Dosen,Mahasiswa',
        ]);

        $anggota->update($request->all());

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
