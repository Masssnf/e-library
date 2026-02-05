@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen User</h2>
            <p class="text-sm text-gray-500">Kelola akun login untuk Admin, Dosen, dan Mahasiswa.</p>
        </div>

        <div class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center">
            <div class="p-2 bg-white/20 rounded-lg mr-4 backdrop-blur-sm">
                <i data-lucide="users" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <p class="text-xs text-pink-100 uppercase font-semibold tracking-wider">Total Akun</p>
                <p class="text-2xl font-bold">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Toolbar -->
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border-gray-300 focus:ring-indigo-500 text-sm shadow-sm"
                        placeholder="Cari Nama atau Email...">
                </div>

                <!-- Filter Role -->
                <div class="w-full md:w-48">
                    <select name="role" onchange="this.form.submit()"
                        class="w-full py-2.5 rounded-lg border-gray-300 focus:ring-indigo-500 text-sm shadow-sm">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="dosen" {{ request('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    </select>
                </div>

                <!-- Tombol Tambah -->
                <a href="{{ route('admin.users.create') }}"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition flex items-center shadow-md text-sm font-medium whitespace-nowrap">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Tambah User
                </a>
            </form>
        </div>

        @if(session('success'))
            <div class="px-6 pt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center">
                    <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="px-6 pt-6">
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center">
                    <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="p-6">
            <div class="overflow-x-auto rounded-lg border border-gray-100">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 font-semibold uppercase tracking-wider text-xs">
                        <tr>
                            <th class="px-6 py-4 w-12 text-center">No</th>
                            <th class="px-6 py-4">Nama User</th>
                            <th class="px-6 py-4">Email Login</th>
                            <th class="px-6 py-4 text-center">Role</th>
                            <th class="px-6 py-4 text-center">Bergabung</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition group">
                                <td class="px-6 py-4 text-center text-gray-400 font-medium">
                                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold mr-3 text-xs uppercase">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $roleClass = match ($user->role) {
                                            'admin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                            'dosen' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'mahasiswa' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            default => 'bg-gray-100 text-gray-700'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-bold rounded-full border {{ $roleClass }} capitalize">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 text-xs">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                            title="Edit Password/Role">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus user {{ $user->name }}? User tidak akan bisa login lagi.');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                    title="Hapus User">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
            {{ $users->links() }}
        </div>
    </div>
@endsection