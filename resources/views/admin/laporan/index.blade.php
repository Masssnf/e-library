@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Laporan Perpustakaan</h2>
        <p class="text-sm text-gray-500">Rekapitulasi data peminjaman berdasarkan periode.</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-auto">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="w-full border-gray-300 rounded-lg focus:ring-indigo-500">
            </div>
            <div class="w-full md:w-auto">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="w-full border-gray-300 rounded-lg focus:ring-indigo-500">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 flex items-center">
                    <i data-lucide="filter" class="w-4 h-4 mr-2"></i> Tampilkan
                </button>
                <a href="{{ route('admin.laporan.cetak', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                    target="_blank"
                    class="bg-gray-800 text-white px-5 py-2.5 rounded-lg hover:bg-gray-900 flex items-center">
                    <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Cetak PDF
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50">
            <h3 class="font-bold text-gray-800">Hasil Laporan ({{ count($laporan) }} Data)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-100 text-gray-700 font-semibold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Peminjam</th>
                        <th class="px-6 py-3">Buku</th>
                        <th class="px-6 py-3 text-center">Tgl Pinjam</th>
                        <th class="px-6 py-3 text-center">Tgl Kembali</th>
                        <th class="px-6 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($laporan as $item)
                        <tr>
                            <td class="px-6 py-3 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 font-mono text-xs">{{ $item->kode_peminjaman }}</td>
                            <td class="px-6 py-3">{{ $item->anggota->nama_anggota }}</td>
                            <td class="px-6 py-3">{{ $item->buku->judul }}</td>
                            <td class="px-6 py-3 text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td class="px-6 py-3 text-center">
                                {{ $item->tanggal_pengembalian ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                <span
                                    class="px-2 py-1 rounded text-xs font-bold 
                                    {{ $item->status == 'Dikembalikan' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center">Tidak ada data pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection