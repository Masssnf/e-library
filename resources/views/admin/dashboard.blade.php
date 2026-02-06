@extends('layouts.admin')

@section('content')
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-8 mb-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-2">Selamat Datang, Admin Slot!</h2>
            <p class="text-indigo-100">Berikut adalah ringkasan aktivitas perpustakaan hari ini.</p>
        </div>
        <!-- Dekorasi Circle Background -->
        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
    </div>
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Total Buku -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <i data-lucide="book" class="w-6 h-6"></i>
                </div>
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Buku</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalBuku }}</h3>
            <p class="text-sm text-green-500 mt-2 flex items-center">
                <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i> +5% bulan ini
            </p>
        </div>

        <!-- Card 2: Total Anggota (Baru) -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Anggota</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalAnggota }}</h3>
            <p class="text-sm text-indigo-500 mt-2 flex items-center">
                <i data-lucide="user-plus" class="w-4 h-4 mr-1"></i> 12 baru minggu ini
            </p>
        </div>

        <!-- Card 3: Peminjaman -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-orange-50 text-orange-600 rounded-lg">
                    <i data-lucide="repeat" class="w-6 h-6"></i>
                </div>
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dipinjam</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $sedangDipinjam }}</h3>
            <p class="text-sm text-gray-500 mt-2">Sedang berlangsung</p>
        </div>

        <!-- Card 4: Terlambat -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                    <i data-lucide="alert-circle" class="w-6 h-6"></i>
                </div>
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Terlambat</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">5</h3>
            <p class="text-sm text-red-500 mt-2">Perlu penanganan</p>
        </div>
    </div>

    <!-- Section Aktivitas (Contoh Layout Tambahan) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 text-lg mb-4">Aktivitas Terkini</h3>
        <div class="space-y-4">
            <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mr-4">
                    <i data-lucide="check" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Budi Santoso mengembalikan buku "Laravel 11"</p>
                    <p class="text-xs text-gray-500">Baru saja</p>
                </div>
            </div>
            <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-4">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Siti Aminah meminjam buku "UI/UX Design"</p>
                    <p class="text-xs text-gray-500">15 menit yang lalu</p>
                </div>
            </div>
        </div>
    </div>
@endsection