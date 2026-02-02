@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Statistik Perpustakaan</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Card Contoh -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Buku</p>
                    <p class="text-3xl font-bold text-gray-800">1,240</p>
                </div>
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-full">
                    <i data-lucide="book-open"></i>
                </div>
            </div>
        </div>
    </div>
@endsection
