@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Pengguna</h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola akun pengguna, status akses, perangkat, dan riwayat login.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('superadmin.pengguna.create') }}"
               class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
                Tambah Baru
            </a>

            <form action="{{ route('superadmin.pengguna.import') }}" method="POST" enctype="multipart/form-data" class="inline-flex items-center gap-2">
                @csrf
                <input type="file" name="file" class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200">
                <button type="submit"
                        class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                    Import Excel
                </button>
            </form>

            <a href="{{ route('superadmin.pengguna.export') }}"
               class="inline-flex items-center rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-2.5 text-sm font-medium text-emerald-700 transition hover:bg-emerald-100">
                Export
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <div class="mb-1 font-semibold">Terjadi kesalahan:</div>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('superadmin.pengguna.index') }}">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Cari</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Username / Nama / Email / NIP / NRP"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Role</label>
                    <select name="role"
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        <option value="">Semua Role</option>
                        <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="pegawai" {{ request('role') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                    <select name="status"
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        <option value="">Semua Status</option>
                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">OPD / Unit Kerja</label>
                    <input type="text"
                           name="opd"
                           value="{{ request('opd') }}"
                           placeholder="Nama OPD / Unit Kerja"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="inline-flex items-center rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-900">
                        Filter
                    </button>

                    <a href="{{ route('superadmin.pengguna.index') }}"
                       class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <form action="{{ route('superadmin.pengguna.bulk-status') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-4 flex flex-wrap items-center gap-2">
            <button type="submit"
                    name="status"
                    value="Aktif"
                    class="inline-flex items-center rounded-xl border border-green-300 bg-green-50 px-4 py-2 text-sm font-medium text-green-700 transition hover:bg-green-100">
                Aktifkan Terpilih
            </button>

            <button type="submit"
                    name="status"
                    value="Nonaktif"
                    class="inline-flex items-center rounded-xl border border-red-300 bg-red-50 px-4 py-2 text-sm font-medium text-red-700 transition hover:bg-red-100">
                Nonaktifkan Terpilih
            </button>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left">
                                <input type="checkbox" id="checkAll" class="h-4 w-4 rounded border-slate-300">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Username</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Nama Lengkap</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">NIP / NRP</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">OPD</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Terakhir Login</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-600">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3 align-top">
                                    <input type="checkbox"
                                           name="user_ids[]"
                                           value="{{ $user->id }}"
                                           class="user-checkbox h-4 w-4 rounded border-slate-300">
                                </td>

                                <td class="px-4 py-3 align-top text-slate-700">
                                    {{ $user->id }}
                                </td>

                                <td class="px-4 py-3 align-top">
                                    <div class="font-medium text-slate-800">
                                        {{ $user->username ?? '-' }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        {{ $user->email }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 align-top text-slate-700">
                                    {{ $user->name }}
                                </td>

                                <td class="px-4 py-3 align-top text-slate-600">
                                    {{ $user->nip ?: '-' }}
                                </td>

                                <td class="px-4 py-3 align-top">
                                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 align-top text-slate-600">
                                    {{ $user->unit_kerja ?: '-' }}
                                </td>

                                <td class="px-4 py-3 align-top">
                                    @if($user->status === 'Aktif')
                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 align-top text-slate-600">
                                    {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('d-m-Y H:i') : '-' }}
                                </td>

                                <td class="px-4 py-3 align-top">
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('superadmin.pengguna.edit', $user->id) }}"
                                           class="inline-flex items-center rounded-lg bg-amber-500 px-3 py-2 text-xs font-medium text-white transition hover:bg-amber-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('superadmin.pengguna.reset', $user->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Reset password pengguna ini ke password123?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center rounded-lg bg-slate-600 px-3 py-2 text-xs font-medium text-white transition hover:bg-slate-700">
                                                Reset
                                            </button>
                                        </form>

                                        <form action="{{ route('superadmin.pengguna.status', $user->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Ubah status pengguna ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center rounded-lg {{ $user->status === 'Aktif' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} px-3 py-2 text-xs font-medium text-white transition">
                                                {{ $user->status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>

                                        <a href="{{ route('superadmin.pengguna.riwayat-login', $user->id) }}"
                                           class="inline-flex items-center rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-medium text-blue-700 transition hover:bg-blue-100">
                                            Riwayat
                                        </a>

                                        <a href="{{ route('superadmin.pengguna.perangkat', $user->id) }}"
                                           class="inline-flex items-center rounded-lg border border-purple-200 bg-purple-50 px-3 py-2 text-xs font-medium text-purple-700 transition hover:bg-purple-100">
                                            Perangkat
                                        </a>

                                        <a href="{{ route('superadmin.pengguna.lokasi-absen', $user->id) }}"
                                           class="inline-flex items-center rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-medium text-emerald-700 transition hover:bg-emerald-100">
                                            Lokasi
                                        </a>

                                        <a href="{{ route('superadmin.pengguna.detail-akses', $user->id) }}"
                                           class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-100">
                                            Akses
                                        </a>

                                        @if($user->role !== 'superadmin')
                                            <form action="{{ route('superadmin.pengguna.delete', $user->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white transition hover:bg-red-700">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-8 text-center text-sm text-slate-500">
                                    Belum ada data pengguna.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($users, 'links'))
                <div class="border-t border-slate-200 px-4 py-3">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.user-checkbox');

        if (checkAll) {
            checkAll.addEventListener('change', function () {
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = checkAll.checked;
                });
            });
        }
    });
</script>
@endsection