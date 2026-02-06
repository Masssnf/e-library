@extends('layouts.mahasiswa')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Lapor Kehilangan / Kerusakan</h2>

        @if($pinjamanAktif->isEmpty())
            <div class="bg-blue-50 text-blue-700 p-4 rounded-lg text-center">
                Anda tidak memiliki buku yang sedang dipinjam.
            </div>
        @else
            <form action="{{ route('mahasiswa.kehilangan.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Buku Bermasalah</label>
                    <select name="peminjaman_id" class="w-full border-gray-300 rounded-lg py-2.5" required>
                        @foreach($pinjamanAktif as $pinjam)
                            <option value="{{ $pinjam->id }}">
                                {{ $pinjam->buku->judul }} (Dipinjam: {{ $pinjam->tanggal_pinjam }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan Kejadian</label>
                    <textarea name="keterangan" rows="4" class="w-full border-gray-300 rounded-lg"
                        placeholder="Contoh: Buku tertinggal di kelas / Buku terkena air..." required></textarea>
                </div>

                <button type="submit" class="w-full bg-red-600 text-white py-2.5 rounded-lg hover:bg-red-700 font-medium">
                    Kirim Laporan
                </button>
            </form>
        @endif
    </div>
@endsection