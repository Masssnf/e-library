<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library Mahasiswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Icon Library (Gunakan CDN JSDelivr) -->
    <script
        src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js">
    </script>
</head>

<body class="bg-gray-50 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-xl font-bold text-emerald-600">E-Library MHS</span>
                    </div>

                    <!-- MENU MAHASISWA -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <!-- Daftar Buku (Aktif saat di Dashboard) -->
                        <a href="{{ route('dashboard') }}"
                            class="border-emerald-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Daftar Buku
                        </a>

                        <!-- Peminjaman -->
                        <a href="#"
                            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Peminjaman
                        </a>

                        <!-- Pengembalian -->
                        <a href="#"
                            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Pengembalian
                        </a>

                        <!-- Kehilangan -->
                        <a href="#"
                            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Kehilangan
                        </a>
                    </div>
                </div>

                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-gray-500 hover:text-red-600 font-medium text-sm">
                            Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Script untuk merender icon -->
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
