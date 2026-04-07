@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Tambah Pengguna</h1>
        <p class="mt-1 text-sm text-slate-500">Tambahkan akun pengguna baru ke sistem.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <div class="font-semibold mb-1">Terjadi kesalahan:</div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-5xl">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-700">Form Tambah Pengguna</h2>
            </div>

            <form action="{{ route('superadmin.pengguna.store') }}" method="POST" class="p-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="Masukkan email"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            NIP
                        </label>
                        <input type="text" name="nip" value="{{ old('nip') }}"
                            placeholder="Masukkan NIP"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select name="role"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">- Pilih Role -</option>
                            <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="pegawai" {{ old('role') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            OPD / Unit Kerja
                        </label>
                        <input type="text" name="unit_kerja" value="{{ old('unit_kerja') }}"
                            placeholder="Contoh: Dinas Pendidikan"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password"
                            placeholder="Masukkan password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation"
                            placeholder="Ulangi password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Status
                        </label>
                        <select name="status"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex gap-3 border-t border-slate-200 pt-6">
                    <button type="submit"
                        class="rounded-xl bg-blue-600 px-5 py-3 text-sm text-white hover:bg-blue-700">
                        Simpan
                    </button>

                    <a href="{{ route('superadmin.pengguna.index') }}"
                        class="rounded-xl border border-slate-300 px-5 py-3 text-sm text-slate-700 hover:bg-slate-50">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection