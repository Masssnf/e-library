@extends('layouts.admin')

@section('content')
    <!-- Header & Stats Widget -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Anggota</h2>
            <p class="text-sm text-gray-500">Kelola data mahasiswa, dosen, dan karyawan.</p>
        </div>

        <!-- Widget Total Anggota -->
        <div
            class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-xl shadow-lg flex items-center transform hover:scale-105 transition duration-300">
            <div class="p-2 bg-white/20 rounded-lg mr-4 backdrop-blur-sm">
                <i data-lucide="users" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <p class="text-xs text-indigo-100 uppercase font-semibold tracking-wider">Total Anggota</p>
                <p class="text-2xl font-bold">{{ $totalAnggota }}</p>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Toolbar: Search & Filter & Add Button -->
        <div
            class="p-6 border-b border-gray-100 flex flex-col lg:flex-row justify-between lg:items-center gap-4 bg-gray-50/50">

            <!-- Form Pencarian & Filter -->
            <form action="{{ route('admin.anggota.index') }}" method="GET"
                class="flex flex-col sm:flex-row gap-3 flex-1 lg:max-w-xl">
                <!-- Search Input -->
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm"
                        placeholder="Cari Nama atau Kode Anggota...">
                </div>

                <!-- Sort Dropdown -->
                <div class="w-full sm:w-48">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i data-lucide="arrow-up-down" class="w-4 h-4"></i>
                        </span>
                        <select name="sort" onchange="this.form.submit()"
                            class="w-full pl-10 pr-8 py-2.5 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm cursor-pointer">
                            <option value="">Urutan Default (Terbaru)</option>
                            <option value="kode_asc" {{ request('sort') == 'kode_asc' ? 'selected' : '' }}>Kode (A-Z)</option>
                            <option value="kode_desc" {{ request('sort') == 'kode_desc' ? 'selected' : '' }}>Kode (Z-A)
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Tombol Cari (Optional jika ingin enter saja) -->
                <button type="submit"
                    class="bg-white border border-gray-300 text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-50 transition shadow-sm text-sm font-medium">
                    Cari
                </button>
            </form>

            <!-- Tombol Tambah -->
            <a href="{{ route('admin.anggota.create') }}"
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition flex items-center shadow-md shadow-indigo-200 text-sm font-medium whitespace-nowrap">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Tambah Anggota
            </a>
        </div>

        <!-- Alert Sukses -->
        @if(session('success'))
            <div class="px-6 pt-6">
                <div
                    class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center shadow-sm">
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
                            <th class="px-6 py-4 w-32 text-center">Kode</th>
                            <th class="px-6 py-4">Nama Anggota</th>
                            <th class="px-6 py-4 text-center">Jenis Anggota</th>
                            <th class="px-6 py-4 text-center">Telepon</th>
                            <th class="px-6 py-4 text-center">Alamat</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($anggotas as $anggota)
                            <tr class="hover:bg-gray-50 transition duration-150 group">
                                <!-- Nomor Urut -->
                                <td class="px-6 py-4 text-center text-gray-400 font-medium group-hover:text-indigo-500">
                                    {{ $loop->iteration + ($anggotas->currentPage() - 1) * $anggotas->perPage() }}
                                </td>

                                <!-- Kode Anggota -->
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="font-mono text-xs font-bold bg-gray-100 text-gray-600 px-2 py-1 rounded border border-gray-200">
                                        {{ $anggota->kode_anggota }}
                                    </span>
                                </td>

                                <!-- Nama Anggota -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-indigo-600 font-bold mr-3 shadow-sm border border-indigo-50 text-xs">
                                            {{ substr($anggota->nama_anggota, 0, 1) }}
                                        </div>
                                        <div class="font-bold text-gray-800 group-hover:text-indigo-600 transition">
                                            {{ $anggota->nama_anggota }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Jenis Anggota -->
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $badgeClass = match ($anggota->jenis_anggota) {
                                            'Mahasiswa' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            'Dosen' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'Karyawan' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            default => 'bg-gray-100 text-gray-700'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-bold rounded-full border {{ $badgeClass }}">
                                        {{ $anggota->jenis_anggota }}
                                    </span>
                                </td>

                                <!-- Telepon -->
                                <td class="px-6 py-4 text-center text-gray-600">
                                    {{ $anggota->no_telepon }}
                                </td>

                                <!-- Alamat -->
                                <td class="px-6 py-4 text-center text-gray-500 text-xs">
                                    {{ Str::limit($anggota->alamat, 20) }}
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.anggota.edit', $anggota->id) }}"
                                            class="p-2 bg-white border border-gray-200 rounded-lg text-blue-600 hover:bg-blue-50 hover:border-blue-300 transition shadow-sm"
                                            title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.anggota.destroy', $anggota->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data {{ $anggota->nama_anggota }}?');">
                                            @csrf
                                            @method('DELETE')
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
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <div class="bg-gray-50 p-4 rounded-full mb-3">
                                            <i data-lucide="search-x" class="w-8 h-8 text-gray-300"></i>
                                        </div>
                                        <p class="text-base font-medium text-gray-500">Data tidak ditemukan.</p>
                                        <p class="text-sm">Coba kata kunci pencarian lain.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
            {{ $anggotas->links() }}
        </div>
    </div>
@endsection