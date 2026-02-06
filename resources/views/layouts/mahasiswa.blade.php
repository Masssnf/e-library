<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library Mahasiswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Icon Library -->
    <script
        src="[https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js](https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js)"></script>
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

                    <!-- MENU MAHASISWA (UPDATED) -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}"
                            class="{{ request()->routeIs('dashboard') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Beranda
                        </a>

                        <!-- Katalog Buku (NEW) -->
                        <a href="{{ route('mahasiswa.buku.index') }}"
                            class="{{ request()->routeIs('mahasiswa.buku.*') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Katalog Buku
                        </a>

                        {{-- Kehilangan --}}
                        <a href="{{ route('mahasiswa.kehilangan.create') }}"
                            class="{{ request()->routeIs('mahasiswa.kehilangan.*') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Lapor Kehilangan
                        </a>

                        <!-- Riwayat Peminjaman (NEW) -->
                        <a href="{{ route('mahasiswa.peminjaman.index') }}"
                            class="{{ request()->routeIs('mahasiswa.peminjaman.*') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Riwayat Peminjaman
                        </a>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="flex items-center mr-4">
                        <span class="text-sm text-gray-600 mr-2">{{ Auth::user()->name }}</span>
                        <div
                            class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-gray-500 hover:text-red-600 font-medium text-sm">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Alert Sukses Global -->
        @if(session('success'))
            <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Alert Error Global -->
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

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