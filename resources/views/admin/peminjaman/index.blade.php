@extends('layouts.admin')

@section('content')
    <!-- Header & Stats Widget -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Sirkulasi Peminjaman</h2>
            <p class="text-sm text-gray-500">Kelola transaksi peminjaman dan pengembalian buku.</p>
        </div>

        <!-- Widget Total Transaksi -->
        <div
            class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center transform hover:scale-105 transition duration-300">
            <div class="p-2 bg-white/20 rounded-lg mr-4 backdrop-blur-sm">
                <i data-lucide="repeat" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <p class="text-xs text-orange-100 uppercase font-semibold tracking-wider">Total Transaksi</p>
                <p class="text-2xl font-bold">{{ $totalPeminjaman }}</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
            <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Main Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Toolbar: Search & Filter -->
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <form action="{{ route('admin.peminjaman.index') }}" method="GET"
                class="flex flex-col lg:flex-row gap-4 justify-between">
                <div class="flex flex-col md:flex-row gap-4 flex-1">
                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition"
                            placeholder="Cari Kode, Nama Peminjam, atau Judul Buku...">
                    </div>

                    <!-- Filter Status -->
                    <div class="w-full md:w-48">
                        <select name="status" onchange="this.form.submit()"
                            class="w-full py-2.5 rounded-lg border-gray-300 focus:ring-indigo-500 text-sm shadow-sm cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>
                                Dikembalikan</option>
                            <option value="Telat" {{ request('status') == 'Telat' ? 'selected' : '' }}>Telat</option>
                        </select>
                    </div>
                </div>

                <!-- Tombol Tambah Transaksi -->
                <a href="{{ route('admin.peminjaman.create') }}"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition flex items-center shadow-md text-sm font-medium whitespace-nowrap">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Transaksi Baru
                </a>
            </form>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 font-semibold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-center w-24">Kode</th>
                        <th class="px-6 py-4">Peminjam</th>
                        <th class="px-6 py-4">Buku</th>
                        <th class="px-6 py-4 text-center">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-center">Batas Kembali</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peminjamans as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Kode Peminjaman -->
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="font-mono text-xs font-bold bg-indigo-50 text-indigo-600 px-2 py-1 rounded border border-indigo-100">
                                    {{ $item->kode_peminjaman }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $item->anggota->nama_anggota }}</div>
                                <div class="text-xs text-gray-500">{{ $item->anggota->kode_anggota }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $item->buku->judul }}</div>
                                <div class="text-xs text-gray-500">{{ $item->buku->kode_buku }}</div>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center text-red-600 font-medium">
                                {{ \Carbon\Carbon::parse($item->tanggal_wajib_kembali)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->status == 'Dipinjam')
                                    <span
                                        class="bg-yellow-100 text-yellow-800 text-xs px-2.5 py-0.5 rounded-full border border-yellow-200 font-medium">Dipinjam</span>
                                @elseif($item->status == 'Dikembalikan')
                                    <span
                                        class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-0.5 rounded-full border border-emerald-200 font-medium">Dikembalikan</span>
                                @else
                                    <span
                                        class="bg-red-100 text-red-800 text-xs px-2.5 py-0.5 rounded-full border border-red-200 font-medium">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->status == 'Dipinjam')
                                    <form action="{{ route('admin.peminjaman.complete', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Buku dikembalikan? Stok akan bertambah.');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="bg-white border border-emerald-500 text-emerald-600 px-3 py-1.5 rounded text-xs hover:bg-emerald-50 transition flex items-center mx-auto shadow-sm"
                                            title="Tandai Selesai">
                                            <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i> Selesai
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs italic flex justify-center items-center">
                                        <i data-lucide="check" class="w-3 h-3 mr-1"></i> Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-50 p-4 rounded-full mb-3">
                                        <i data-lucide="search-x" class="w-8 h-8 text-gray-300"></i>
                                    </div>
                                    <p class="text-base font-medium text-gray-500">Data tidak ditemukan.</p>
                                    <p class="text-sm">Silakan buat transaksi baru atau ubah pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
            {{ $peminjamans->links() }}
        </div>
    </div>
@endsection