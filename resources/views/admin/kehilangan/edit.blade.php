@extends('layouts.admin')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Proses Laporan #{{ $kehilangan->kode_kehilangan }}</h2>

        <div class="bg-gray-50 p-4 rounded-lg mb-6 text-sm text-gray-600">
            <p><strong>Anggota:</strong> {{ $kehilangan->anggota->nama_anggota }}</p>
            <p><strong>Buku:</strong> {{ $kehilangan->buku->judul }}</p>
            <p><strong>Keterangan:</strong> {{ $kehilangan->keterangan }}</p>
        </div>

        <form action="{{ route('admin.kehilangan.update', $kehilangan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tetapkan Denda (Rp)</label>
                <input type="number" name="denda" value="{{ $kehilangan->denda }}" class="w-full border-gray-300 rounded-lg"
                    min="0" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status Laporan</label>
                <select name="status" class="w-full border-gray-300 rounded-lg">
                    <option value="Diajukan" {{ $kehilangan->status == 'Diajukan' ? 'selected' : '' }}>Diajukan (Review)
                    </option>
                    <option value="Konfirmasi" {{ $kehilangan->status == 'Konfirmasi' ? 'selected' : '' }}>Konfirmasi (Tagih
                        Denda)</option>
                    <option value="Selesai" {{ $kehilangan->status == 'Selesai' ? 'selected' : '' }}>Selesai (Lunas & Tutup
                        Kasus)</option>
                    <option value="Ditolak" {{ $kehilangan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.kehilangan.index') }}"
                    class="px-4 py-2 bg-gray-100 rounded-lg text-gray-700">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
@endsection