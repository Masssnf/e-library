@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 max-w-4xl mx-auto">
        <div class="mb-8 pb-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Tambah Buku Baru</h2>
                <p class="text-sm text-gray-500 mt-1">Masukkan detail buku ke dalam katalog.</p>
            </div>
            <a href="{{ route('admin.buku.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.buku.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Jenis Buku (Ditaruh Paling Atas karena menentukan kode) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Buku</label>
                    <select name="jenis_buku"
                        class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-2.5">
                        <option value="Fiksi">Fiksi (Kode: FS)</option>
                        <option value="Non-Fiksi">Non-Fiksi (Kode: NF)</option>
                        <option value="Pelajaran">Pelajaran (Kode: PD)</option>
                        <option value="Referensi">Referensi (Kode: RF)</option>
                        <option value="Jurnal">Jurnal (Kode: JR)</option>
                        <option value="Majalah">Majalah (Kode: MJ)</option>
                    </select>
                    <p class="text-xs text-indigo-500 mt-1">*Kode buku akan menyesuaikan jenis yang dipilih.</p>
                </div>

                <!-- Kode Buku (Otomatis Backend) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Buku</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i data-lucide="hash" class="w-4 h-4"></i>
                        </span>
                        <input type="text" value="Otomatis (FS... / PD... / dll)"
                            class="w-full pl-10 border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed py-2.5"
                            readonly>
                    </div>
                </div>

                <!-- Judul Buku (Full Width) -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Buku</label>
                    <input type="text" name="judul"
                        class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-2.5"
                        placeholder="Contoh: Belajar Laravel 11" required>
                </div>

                <!-- Pengarang -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pengarang</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i data-lucide="pen-tool" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="pengarang"
                            class="w-full pl-10 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-2.5"
                            required>
                    </div>
                </div>

                <!-- Penerbit -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Penerbit</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i data-lucide="building" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="penerbit"
                            class="w-full pl-10 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-2.5"
                            required>
                    </div>
                </div>

                <!-- Tahun Terbit -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit"
                        class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-2.5"
                        placeholder="YYYY" min="1900" max="{{ date('Y') + 1 }}" required>
                </div>

            </div>

            <div class="mt-8 flex justify-end space-x-4 border-t border-gray-100 pt-6">
                <a href="{{ route('admin.buku.index') }}"
                    class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">Batal</a>
                <button type="submit"
                    class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md font-medium transition flex items-center">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i> Simpan Buku
                </button>
            </div>
        </form>
    </div>
@endsection