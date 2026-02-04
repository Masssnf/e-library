@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 max-w-4xl mx-auto">
        <div class="mb-8 pb-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Edit Data Buku</h2>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi buku di bawah ini.</p>
            </div>
            <a href="{{ route('admin.buku.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.buku.update', $buku->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode Buku -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Buku</label>
                    <input type="text" name="kode_buku" value="{{ $buku->kode_buku }}"
                        class="w-full border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed py-2.5"
                        readonly>
                </div>

                <!-- Jenis Buku -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Buku</label>
                    <select name="jenis_buku" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5">
                        <option value="Fiksi" {{ $buku->jenis_buku == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                        <option value="Non-Fiksi" {{ $buku->jenis_buku == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                        <option value="Pelajaran" {{ $buku->jenis_buku == 'Pelajaran' ? 'selected' : '' }}>Pelajaran</option>
                        <option value="Referensi" {{ $buku->jenis_buku == 'Referensi' ? 'selected' : '' }}>Referensi</option>
                        <option value="Jurnal" {{ $buku->jenis_buku == 'Jurnal' ? 'selected' : '' }}>Jurnal</option>
                        <option value="Majalah" {{ $buku->jenis_buku == 'Majalah' ? 'selected' : '' }}>Majalah</option>
                    </select>
                </div>

                <!-- Judul Buku -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Buku</label>
                    <input type="text" name="judul" value="{{ $buku->judul }}"
                        class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5" required>
                </div>

                <!-- Pengarang -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pengarang</label>
                    <input type="text" name="pengarang" value="{{ $buku->pengarang }}"
                        class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5" required>
                </div>

                <!-- Penerbit -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Penerbit</label>
                    <input type="text" name="penerbit" value="{{ $buku->penerbit }}"
                        class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5" required>
                </div>

                <!-- Tahun Terbit -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ $buku->tahun_terbit }}"
                        class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5" required>
                </div>

                <!-- Stok Buku (Tambahan) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Buku</label>
                    <input type="number" name="stok" value="{{ $buku->stok }}"
                        class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5" min="0" required>
                </div>

                <!-- Status Buku -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Buku</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5">
                        <option value="Tersedia" {{ $buku->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Dipinjam" {{ $buku->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="Rusak" {{ $buku->status == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="Hilang" {{ $buku->status == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4 border-t border-gray-100 pt-6">
                <a href="{{ route('admin.buku.index') }}"
                    class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">Batal</a>
                <button type="submit"
                    class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md font-medium transition flex items-center">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i> Update Buku
                </button>
            </div>
        </form>
    </div>
@endsection