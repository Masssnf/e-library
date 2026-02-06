@extends('layouts.mahasiswa')

@section('content')
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Peminjaman Saya</h2>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-800 font-semibold">
                    <tr>
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Judul Buku</th>
                        <th class="px-6 py-4 text-center">Tanggal Pinjam</th>
                        <th class="px-6 py-4 text-center">Batas Kembali</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peminjamans as $item)
                        <tr>
                            <td class="px-6 py-4 font-mono text-xs">{{ $item->kode_peminjaman }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->buku->judul }}</td>

                            <td class="px-6 py-4 text-center">
                                @if($item->tanggal_pinjam)
                                    {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($item->tanggal_wajib_kembali)
                                    {{ \Carbon\Carbon::parse($item->tanggal_wajib_kembali)->format('d M Y') }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($item->status == 'Menunggu Konfirmasi')
                                    <span
                                        class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold border border-gray-200">Menunggu</span>
                                @elseif($item->status == 'Dipinjam')
                                    <span
                                        class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold border border-yellow-200">Dipinjam</span>
                                @elseif($item->status == 'Dikembalikan')
                                    <span
                                        class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold border border-emerald-200">Selesai</span>
                                @elseif($item->status == 'Ditolak')
                                    <span
                                        class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold border border-red-200">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection