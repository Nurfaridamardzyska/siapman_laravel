@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Perangkat</h1>

        <a href="{{ route('superadmin.absensi.perangkat-pengguna.index') }}"
           class="text-sm text-gray-600 hover:underline">
            ← Kembali
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">

        <form method="POST" action="{{ route('superadmin.absensi.perangkat-pengguna.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                <select name="user_id" class="w-full border rounded p-2">
                    <option value="">-- pilih user --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Device ID</label>
                <input type="text" name="device_id" value="{{ old('device_id') }}"
                       class="w-full border rounded p-2" placeholder="contoh: ABC-123">
                @error('device_id') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-6">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active'))>
                    <span class="text-sm text-gray-700">Aktif</span>
                </label>
            </div>

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </form>

    </div>

</div>
@endsection