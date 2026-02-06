<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - E-Library</title>
    <!-- Ini memanggil Tailwind CSS bawaan Breeze -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Icon Library (Gunakan CDN JSDelivr) -->
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
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
                    class="flex items-center px-4 py-2 rounded-md transition {{ request()->routeIs('admin.buku.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="book" class="w-5 h-5 mr-3"></i> Data Buku
                </a>

                <!-- Data User (Placeholder) -->
                <a href="{{ route('admin.users.index') }}"
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
                <a href="{{ route('admin.peminjaman.index') }}"
                    class="flex items-center px-4 py-2 rounded-md transition {{ request()->routeIs('admin.peminjaman.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="repeat" class="w-5 h-5 mr-3"></i> Data Peminjaman
                </a>

                <!-- Data Kehilangan -->
                <a href="{{ route('admin.kehilangan.index') }}"
                    class="flex items-center px-4 py-2 rounded-md transition {{ request()->routeIs('admin.kehilangan.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="alert-circle" class="w-5 h-5 mr-3"></i> Data Kehilangan
                </a>

                <!-- Data Laporan -->
                <a href="{{ route('admin.laporan.index') }}"
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

    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // 1. Menangani Pesan Sukses (Session)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif

        // 2. Menangani Pesan Error (Session)
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        @endif

            // 3. Menangani Error Validasi (Form Request)
            // Ini akan muncul jika ada input yang tidak sesuai (misal: kosong, email ganda, dll)
            @if($errors->any())
                var errorMessages = "";
                @foreach($errors->all() as $error)
                    errorMessages += "<li>{{ $error }}</li>";
                @endforeach

                Swal.fire({
                    icon: 'error',
                    title: 'Periksa Kembali Inputan',
                    html: "<ul style='text-align: left; margin-left: 20px;'>" + errorMessages + "</ul>",
                });
            @endif

        // 4. Konfirmasi Delete Otomatis (Opsional)
        // Mengubah semua tombol delete standar menjadi SweetAlert
        document.querySelectorAll('form').forEach(form => {
            // Cek jika form memiliki method DELETE
            if (form.querySelector('input[name="_method"][value="DELETE"]')) {
                form.addEventListener('submit', function (e) {
                    var form = this;
                    e.preventDefault(); // Cegah submit langsung

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Lanjutkan submit jika user klik Ya
                        }
                    });
                });
            }
        });
    </script>
</body>

</html>