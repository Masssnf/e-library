@extends('layouts.mahasiswa')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Katalog Buku</h2>

        <!-- Search -->
        <form action="{{ route('mahasiswa.buku.index') }}" method="GET">
            <div class="relative">
                <input type="text" name="search"
                    class="w-full p-4 pl-12 rounded-lg border border-gray-300 shadow-sm focus:ring-emerald-500"
                    placeholder="Cari judul buku...">
                <i data-lucide="search" class="absolute left-4 top-4 text-gray-400 w-6 h-6"></i>
            </div>
        </form>
    </div>

    <!-- Grid Buku -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($bukus as $buku)
            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col h-full hover:shadow-md transition">
                <div class="h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                    <i data-lucide="book" class="w-12 h-12"></i>
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-wide">{{ $buku->jenis_buku }}</span>
                    <h3 class="mt-1 text-lg font-semibold text-gray-900 line-clamp-2">{{ $buku->judul }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $buku->pengarang }}</p>

                    <div class="mt-auto pt-4 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Stok: {{ $buku->stok }}</span>

                        <form action="{{ route('mahasiswa.buku.ajukan', $buku->id) }}" method="POST"
                            onsubmit="return confirm('Ajukan peminjaman buku ini?');">
                            @csrf
                            <button type="submit"
                                class="bg-emerald-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-emerald-700 transition">
                                Pinjam
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center py-12 text-gray-500">Buku tidak ditemukan.</div>
        @endforelse
    </div>
    <div class="mt-6">
        {{ $bukus->links() }}
    </div>
@endsection