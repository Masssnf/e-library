@extends('layouts.admin')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 max-w-4xl mx-auto">
    <div class="mb-8 pb-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Edit User</h2>
            <p class="text-sm text-gray-500 mt-1">Ubah data akun atau reset password.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Nama -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5" required>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5" required>
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                <select name="role" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5">
                    <option value="mahasiswa" {{ $user->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="dosen" {{ $user->role == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <!-- Reset Password (Optional) -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 mt-2">
                <h3 class="font-semibold text-gray-800 mb-4 text-sm flex items-center">
                    <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Ganti Password (Opsional)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Password Baru</label>
                        <input type="password" name="password" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2" placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2" placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4 border-t border-gray-100 pt-6">
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">Batal</a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md font-medium transition flex items-center">
                <i data-lucide="save" class="w-4 h-4 mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection