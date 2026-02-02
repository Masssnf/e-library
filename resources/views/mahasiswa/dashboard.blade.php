@extends('layouts.mahasiswa')

@section('content')
    <div class="mb-8 relative">
        <input type="text" placeholder="Cari judul buku..."
            class="w-full p-4 pl-12 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 shadow-sm">
        <i data-lucide="search" class="absolute left-4 top-4 text-gray-400 w-6 h-6"></i>
    </div>

    <h2 class="text-xl font-semibold mb-4 text-gray-800">Buku Populer</h2>

    <!-- Grid Buku -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="h-48 bg-gray-200 rounded mb-4"></div>
            <h3 class="font-bold text-gray-900">Judul Buku Contoh</h3>
            <p class="text-sm text-gray-500">Pengarang</p>
        </div>
    </div>
@endsection
