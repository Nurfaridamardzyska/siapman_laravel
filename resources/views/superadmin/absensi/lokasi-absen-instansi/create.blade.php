@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Tambah Lokasi Absen Instansi</h1>

    @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('superadmin.absensi.lokasi-absen-instansi.store') }}" method="POST"
          class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Nama Lokasi</label>
            <input name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium">Latitude</label>
                <input name="latitude" value="{{ old('latitude') }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Longitude</label>
                <input name="longitude" value="{{ old('longitude') }}" class="w-full border rounded px-3 py-2" required>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium">Radius (meter)</label>
                <input type="number" min="1" name="radius" value="{{ old('radius', 50) }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Unit Kerja</label>
                <input name="unit_name" value="{{ old('unit_name') }}"
                       class="w-full border rounded px-3 py-2" placeholder="Opsional">
            </div>
        </div>

        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" checked>
            <span class="text-sm">Aktif</span>
        </label>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('superadmin.absensi.lokasi-absen-instansi.index') }}"
               class="bg-gray-200 px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection