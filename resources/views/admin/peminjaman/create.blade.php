@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 max-w-2xl mx-auto">
        <div class="mb-6 pb-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Transaksi Peminjaman</h2>
            <a href="{{ route('admin.peminjaman.index') }}"
                class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.peminjaman.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Kode Transaksi (Otomatis) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Peminjaman</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i data-lucide="hash" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="kode_peminjaman" value="{{ $kodeOtomatis }}"
                            class="w-full pl-10 border-gray-300 rounded-lg bg-gray-100 text-gray-700 font-bold cursor-not-allowed py-2.5"
                            readonly>
                    </div>
                </div>

                <!-- Pilih Anggota -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Peminjam</label>
                    <select name="anggota_id" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5">
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($anggotas as $anggota)
                            <option value="{{ $anggota->id }}">{{ $anggota->nama_anggota }} ({{ $anggota->kode_anggota }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Buku -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Buku</label>
                    <select name="buku_id" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5">
                        <option value="">-- Pilih Buku --</option>
                        @foreach($bukus as $buku)
                            <option value="{{ $buku->id }}">
                                {{ $buku->judul }} (Sisa Stok: {{ $buku->stok }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1 ml-1">*Hanya buku dengan stok tersedia yang muncul.</p>
                </div>

                <!-- Tanggal Pinjam -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pinjam</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </span>
                        <input type="date" name="tanggal_pinjam" value="{{ date('Y-m-d') }}"
                            class="w-full pl-10 border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5">
                    </div>
                </div>

                <!-- Info Otomatis -->
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 flex items-start">
                    <i data-lucide="info" class="w-5 h-5 text-blue-600 mr-3 mt-0.5"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold">Informasi Sistem:</p>
                        <p>Batas waktu peminjaman adalah <strong>7 hari</strong> dari tanggal pinjam. Stok buku akan
                            berkurang otomatis setelah disimpan.</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.peminjaman.index') }}"
                    class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">Batal</a>
                <button type="submit"
                    class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md font-medium transition flex items-center">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i> Proses Peminjaman
                </button>
            </div>
        </form>
    </div>
@endsection