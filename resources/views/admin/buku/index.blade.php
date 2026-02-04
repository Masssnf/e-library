@extends('layouts.admin')

@section('content')
    <!-- Header & Stats -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Buku</h2>
            <p class="text-sm text-gray-500">Katalog koleksi perpustakaan.</p>
        </div>

        <div
            class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center transform hover:scale-105 transition duration-300">
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
        <!-- Toolbar: Filter & Actions -->
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <form action="{{ route('admin.buku.index') }}" method="GET" class="space-y-4">
                <div class="flex flex-col lg:flex-row gap-4">

                    <!-- Search Input (Judul/Pengarang/Penerbit) -->
                    <div class="flex-1 relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition"
                            placeholder="Cari Judul, Pengarang, Penerbit...">
                    </div>

                    <!-- Filter Jenis Buku -->
                    <div class="w-full lg:w-40">
                        <select name="jenis_buku"
                            class="w-full py-2.5 rounded-lg border-gray-300 focus:ring-indigo-500 text-sm shadow-sm cursor-pointer">
                            <option value="">Semua Jenis</option>
                            @foreach(['Fiksi', 'Non-Fiksi', 'Pelajaran', 'Referensi', 'Jurnal', 'Majalah'] as $jenis)
                                <option value="{{ $jenis }}" {{ request('jenis_buku') == $jenis ? 'selected' : '' }}>{{ $jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Status -->
                    <div class="w-full lg:w-40">
                        <select name="status"
                            class="w-full py-2.5 rounded-lg border-gray-300 focus:ring-indigo-500 text-sm shadow-sm cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="Rusak" {{ request('status') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                            <option value="Hilang" {{ request('status') == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                        </select>
                    </div>

                    <!-- Sorting -->
                    <div class="w-full lg:w-48">
                        <select name="sort"
                            class="w-full py-2.5 rounded-lg border-gray-300 focus:ring-indigo-500 text-sm shadow-sm cursor-pointer">
                            <option value="">Urutan Default</option>
                            <option value="judul_asc" {{ request('sort') == 'judul_asc' ? 'selected' : '' }}>Judul (A-Z)
                            </option>
                            <option value="judul_desc" {{ request('sort') == 'judul_desc' ? 'selected' : '' }}>Judul (Z-A)
                            </option>
                            <option value="tahun_desc" {{ request('sort') == 'tahun_desc' ? 'selected' : '' }}>Tahun (Terbaru)
                            </option>
                            <option value="tahun_asc" {{ request('sort') == 'tahun_asc' ? 'selected' : '' }}>Tahun (Terlama)
                            </option>
                            <option value="stok_asc" {{ request('sort') == 'stok_asc' ? 'selected' : '' }}>Stok (Sedikit)
                            </option>
                            <option value="stok_desc" {{ request('sort') == 'stok_desc' ? 'selected' : '' }}>Stok (Banyak)
                            </option>
                        </select>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2.5 rounded-lg hover:bg-indigo-700 transition shadow-sm text-sm font-medium flex items-center">
                            <i data-lucide="filter" class="w-4 h-4 mr-2"></i> Filter
                        </button>

                        @if(request()->anyFilled(['search', 'jenis_buku', 'status', 'sort']))
                            <a href="{{ route('admin.buku.index') }}"
                                class="bg-white border border-gray-300 text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-50 transition shadow-sm text-sm font-medium flex items-center"
                                title="Reset Filter">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Sub-Header: Add Button -->
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white">
            <div class="text-sm text-gray-500">
                Menampilkan {{ $bukus->count() }} dari {{ $bukus->total() }} data
            </div>
            <a href="{{ route('admin.buku.create') }}"
                class="bg-emerald-600 text-white px-5 py-2 rounded-lg hover:bg-emerald-700 transition flex items-center shadow-md text-sm font-medium">
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
                    <thead class="bg-gray-50 text-gray-700 font-semibold uppercase tracking-wider text-xs">
                        <tr>
                            <th class="px-6 py-4 w-12 text-center">No</th>
                            <th class="px-6 py-4 w-28 text-center">Kode</th>
                            <th class="px-6 py-4">Judul Buku</th>
                            <th class="px-6 py-4">Pengarang</th>
                            <th class="px-6 py-4">Penerbit</th>
                            <th class="px-6 py-4 text-center">Kategori</th>
                            <th class="px-6 py-4 text-center">Tahun</th>
                            <th class="px-6 py-4 text-center">Stok</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($bukus as $buku)
                            <tr class="hover:bg-gray-50 transition group">
                                <!-- Nomor (Tengah) -->
                                <td class="px-6 py-4 text-center text-gray-400 font-medium">
                                    {{ $loop->iteration + ($bukus->currentPage() - 1) * $bukus->perPage() }}
                                </td>

                                <!-- Kode Buku (Tengah) -->
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="font-mono text-xs font-bold bg-gray-100 text-gray-600 px-2 py-1 rounded border border-gray-200">
                                        {{ $buku->kode_buku }}
                                    </span>
                                </td>

                                <!-- Judul Buku -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800 group-hover:text-indigo-600 transition">
                                        {{ $buku->judul }}</div>
                                </td>

                                <!-- Pengarang -->
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $buku->pengarang }}
                                </td>

                                <!-- Penerbit -->
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $buku->penerbit }}
                                </td>

                                <!-- Kategori (Tengah) -->
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-2.5 py-0.5 text-xs rounded-md bg-gray-100 text-gray-600 border border-gray-200">
                                        {{ $buku->jenis_buku }}
                                    </span>
                                </td>

                                <!-- Tahun (Tengah) -->
                                <td class="px-6 py-4 text-center text-gray-500">
                                    {{ $buku->tahun_terbit }}
                                </td>

                                <!-- Stok (Tengah) -->
                                <td class="px-6 py-4 text-center font-semibold text-gray-700">
                                    {{ $buku->stok }}
                                </td>

                                <!-- Status (Tengah & Badge) -->
                                <td class="px-6 py-4 text-center">
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

                                <!-- Aksi (Tengah) -->
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.buku.edit', $buku->id) }}"
                                            class="p-2 bg-white border border-gray-200 rounded-lg text-blue-600 hover:bg-blue-50 hover:border-blue-300 transition shadow-sm"
                                            title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus buku ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-white border border-gray-200 rounded-lg text-red-600 hover:bg-red-50 hover:border-red-300 transition shadow-sm"
                                                title="Hapus">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-50 p-4 rounded-full mb-3">
                                            <i data-lucide="search-x" class="w-8 h-8 text-gray-300"></i>
                                        </div>
                                        <p class="text-base font-medium text-gray-500">Buku tidak ditemukan.</p>
                                        <p class="text-sm">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                                    </div>
                                </td>
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