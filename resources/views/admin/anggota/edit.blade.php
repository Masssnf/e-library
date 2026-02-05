@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 max-w-4xl mx-auto">
        <div class="mb-8 pb-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Edit Data Anggota</h2>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi anggota di bawah ini.</p>
            </div>
            <a href="{{ route('admin.anggota.index') }}"
                class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.anggota.update', $anggota->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode Anggota -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Anggota</label>
                    <input type="text" name="kode_anggota" value="{{ old('kode_anggota', $anggota->kode_anggota) }}" readonly
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5"
                        required>
                </div>

                <!-- Nama Anggota -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_anggota" value="{{ old('nama_anggota', $anggota->nama_anggota) }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5"
                        required>
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $anggota->tempat_lahir) }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5"
                        required>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $anggota->tanggal_lahir) }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5"
                        required>
                </div>

                <!-- Jenis Anggota -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Anggota</label>
                    <select name="jenis_anggota"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5">
                        <option value="Mahasiswa" {{ $anggota->jenis_anggota == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa
                        </option>
                        <option value="Dosen" {{ $anggota->jenis_anggota == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                    </select>
                </div>

                <!-- No Telepon -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', $anggota->no_telepon) }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5"
                        required>
                </div>

                <!-- Alamat (Full Width) -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5"
                        required>{{ old('alamat', $anggota->alamat) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4 border-t border-gray-100 pt-6">
                <a href="{{ route('admin.anggota.index') }}"
                    class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">Batal</a>
                <button type="submit"
                    class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-200 font-medium transition flex items-center">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i> Update Data
                </button>
            </div>
        </form>
    </div>
@endsection