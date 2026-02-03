@extends('layouts.admin')

@section('content')
    <!-- Header & Stats -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Buku</h2>
            <p class="text-sm text-gray-500">Katalog koleksi perpustakaan.</p>
        </div>

        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center">
            <div class="p-2 bg-white/20 rounded-lg mr-4 backdrop-blur-sm">
                <i data-lucide="book" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <p class="text-xs text-blue-100 uppercase font-semibold tracking-wider">Total Koleksi</p>
                <p class="text-2xl font-bold">{{ $totalBuku }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div
            class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50/50">
            <h3 class="font-semibold text-gray-800">Daftar Buku</h3>
            <a href="{{ route('admin.buku.create') }}"
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition flex items-center shadow-md text-sm font-medium">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Tambah Buku
            </a>
        </div>

        @if(session('success'))
            <div class="px-6 pt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center">
                    <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="p-6">
            <div class="overflow-x-auto rounded-lg border border-gray-100">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 font-semibold uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4 w-12 text-center">No</th>
                            <th class="px-6 py-4">Informasi Buku</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Tahun</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($bukus as $buku)
                            <tr class="hover:bg-gray-50 transition group">
                                <td class="px-6 py-4 text-center text-gray-400 font-medium">
                                    {{ $loop->iteration + ($bukus->currentPage() - 1) * $bukus->perPage() }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start">
                                        <div class="h-12 w-9 bg-gray-200 rounded flex-shrink-0 mr-3 overflow-hidden shadow-sm">
                                            <!-- Placeholder Cover Buku -->
                                            <div
                                                class="w-full h-full bg-indigo-100 flex items-center justify-center text-indigo-400">
                                                <i data-lucide="book" class="w-4 h-4"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800 group-hover:text-indigo-600 transition">
                                                {{ $buku->judul }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">
                                                <span class="font-medium">{{ $buku->pengarang }}</span> • {{ $buku->penerbit }}
                                            </div>
                                            <div
                                                class="text-[10px] text-gray-400 mt-1 font-mono bg-gray-100 px-1.5 py-0.5 rounded inline-block">
                                                {{ $buku->kode_buku }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-0.5 text-xs rounded-md bg-gray-100 text-gray-600 border border-gray-200">
                                        {{ $buku->jenis_buku }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $buku->tahun_terbit }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClass = match ($buku->status) {
                                            'Tersedia' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            'Dipinjam' => 'bg-orange-100 text-orange-700 border-orange-200',
                                            'Hilang' => 'bg-red-100 text-red-700 border-red-200',
                                            'Rusak' => 'bg-gray-100 text-gray-700 border-gray-200',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full border {{ $statusClass }}">
                                        {{ $buku->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.buku.edit', $buku->id) }}"
                                            class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-md transition">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus buku ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 text-red-600 hover:bg-red-50 rounded-md transition">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
            {{ $bukus->links() }}
        </div>
    </div>
@endsection