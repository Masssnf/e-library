@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 max-w-4xl mx-auto">
        <div class="mb-8 pb-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Tambah User Baru</h2>
                <p class="text-sm text-gray-500 mt-1">Buat akun login untuk Admin, Dosen, atau Mahasiswa.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5"
                        placeholder="Masukkan nama user" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5"
                        placeholder="user@example.com" required>
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Role (Hak Akses)</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="mahasiswa" class="peer sr-only" checked>
                            <div
                                class="p-4 rounded-lg border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:bg-gray-50 transition text-center">
                                <span
                                    class="block font-semibold text-gray-700 peer-checked:text-emerald-700">Mahasiswa</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="dosen" class="peer sr-only">
                            <div
                                class="p-4 rounded-lg border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50 transition text-center">
                                <span class="block font-semibold text-gray-700 peer-checked:text-blue-700">Dosen</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="admin" class="peer sr-only">
                            <div
                                class="p-4 rounded-lg border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:bg-gray-50 transition text-center">
                                <span class="block font-semibold text-gray-700 peer-checked:text-purple-700">Admin</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input type="password" name="password"
                            class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 py-2.5" required>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4 border-t border-gray-100 pt-6">
                <a href="{{ route('admin.users.index') }}"
                    class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">Batal</a>
                <button type="submit"
                    class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md font-medium transition flex items-center">
                    <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i> Buat User
                </button>
            </div>
        </form>
    </div>
@endsection