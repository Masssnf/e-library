<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - E-Library</title>
    <!-- Ini memanggil Tailwind CSS bawaan Breeze -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Icon Library (Gunakan CDN JSDelivr) -->
    <script
        src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col hidden md:flex">
            <div class="h-16 flex items-center justify-center border-b border-slate-700">
                <h1 class="text-xl font-bold text-indigo-400">E-LIBRARY <span class="text-xs text-gray-400">Admin</span>
                </h1>
            </div>

            <nav class="flex-1 px-2 py-4 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2 rounded-md transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i> Dashboard
                </a>

                <!-- Data Buku (Placeholder) -->
                <a href="{{ route('admin.buku.index') }}"
                    class="flex items-center px-4 py-2 rounded-md transition {{ request()->routeIs('admin.books.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="book" class="w-5 h-5 mr-3"></i> Data Buku
                </a>

                <!-- Data User (Placeholder) -->
                <a href="#"
                    class="flex items-center px-4 py-2 rounded-md transition {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="user-check" class="w-5 h-5 mr-3"></i> Data User
                </a>

                <!-- Data Anggota (SUDAH AKTIF) -->
                <!-- Menggunakan routeIs('admin.anggota.*') agar tetap aktif saat Create/Edit -->
                <a href="{{ route('admin.anggota.index') }}"
                    class="flex items-center px-4 py-2 rounded-md transition {{ request()->routeIs('admin.anggota.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="users" class="w-5 h-5 mr-3"></i> Data Anggota
                </a>

                <!-- Data Peminjaman -->
                <a href="#"
                    class="flex items-center px-4 py-2 rounded-md transition {{ request()->routeIs('admin.peminjaman.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="repeat" class="w-5 h-5 mr-3"></i> Data Peminjaman
                </a>

                <!-- Data Kehilangan -->
                <a href="#"
                    class="flex items-center px-4 py-2 rounded-md transition {{ request()->routeIs('admin.kehilangan.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="alert-circle" class="w-5 h-5 mr-3"></i> Data Kehilangan
                </a>

                <!-- Data Laporan -->
                <a href="#"
                    class="flex items-center px-4 py-2 rounded-md transition {{ request()->routeIs('admin.laporan.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="file-text" class="w-5 h-5 mr-3"></i> Data Laporan
                </a>
            </nav>

            <div class="p-4 border-t border-slate-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center text-slate-400 hover:text-white transition w-full">
                        <i data-lucide="log-out" class="w-5 h-5 mr-3"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Konten Utama -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <main class="p-6">
                <!-- Di sini konten dinamis akan muncul -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Script untuk merender icon -->
    <script>
        lucide.createIcons();
    </script>
</body>

</html>