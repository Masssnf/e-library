@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Data Kehilangan & Denda</h2>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 font-semibold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Anggota</th>
                        <th class="px-6 py-4">Buku</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Denda</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kehilangans as $item)
                        <tr>
                            <td class="px-6 py-4 font-mono text-xs">{{ $item->kode_kehilangan }}</td>
                            <td class="px-6 py-4">{{ $item->anggota->nama_anggota }}</td>
                            <td class="px-6 py-4">{{ $item->buku->judul }}</td>
                            <td class="px-6 py-4 text-xs">{{ Str::limit($item->keterangan, 30) }}</td>
                            <td class="px-6 py-4 text-center font-bold text-red-600">
                                Rp {{ number_format($item->denda, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->status == 'Diajukan')
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">Baru</span>
                                @elseif($item->status == 'Konfirmasi')
                                    <span class="bg-orange-100 text-orange-700 text-xs px-2 py-1 rounded">Menunggu Bayar</span>
                                @elseif($item->status == 'Selesai')
                                    <span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded">Lunas</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.kehilangan.edit', $item->id) }}"
                                    class="text-blue-600 hover:text-blue-800">
                                    <i data-lucide="edit" class="w-4 h-4"></i> Proses
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection