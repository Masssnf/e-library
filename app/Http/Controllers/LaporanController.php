<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        // Default: Ambil tanggal hari ini jika tidak ada filter
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Query Data
        $laporan = Peminjaman::with(['anggota', 'buku'])
            ->whereBetween('tanggal_pinjam', [$startDate, $endDate])
            ->latest()
            ->get(); // Gunakan get() karena untuk laporan biasanya tidak di-paginate saat dicetak

        return view('admin.laporan.index', compact('laporan', 'startDate', 'endDate'));
    }

    public function cetak(Request $request)
    {
        // Ambil tanggal dari request
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Query Data
        $laporan = Peminjaman::with(['anggota', 'buku'])
            ->whereBetween('tanggal_pinjam', [$startDate, $endDate])
            ->latest()
            ->get();

        return view('admin.laporan.cetak', compact('laporan', 'startDate', 'endDate'));
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
