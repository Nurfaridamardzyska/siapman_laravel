@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Tambah Lokasi Absen</h1>

        <a href="{{ route('superadmin.absensi.lokasi-absen.index') }}"
           class="bg-gray-200 text-gray-800 px-4 py-2 rounded">
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('superadmin.absensi.lokasi-absen.store') }}"
          class="bg-white p-4 rounded shadow space-y-4">
        @csrf

        <div>
            <label class="text-sm text-gray-600">OPD/Unit (opsional)</label>
            <select name="unit_id" class="w-full border rounded px-3 py-2">
                <option value="">-- Tidak ditentukan --</option>
                @foreach($units ?? [] as $u)
                    <option value="{{ $u->id }}" @selected(old('unit_id') == $u->id)>{{ $u->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm text-gray-600">Nama Lokasi</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-sm text-gray-600">Latitude</label>
                <input type="number" step="0.0000001" name="latitude" value="{{ old('latitude') }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="text-sm text-gray-600">Longitude</label>
                <input type="number" step="0.0000001" name="longitude" value="{{ old('longitude') }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>
        </div>

        <div>
            <label class="text-sm text-gray-600">Radius (meter)</label>
            <input type="number" name="radius_meters" value="{{ old('radius_meters', 0) }}"
                   class="w-full border rounded px-3 py-2" min="0" required>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', true))>
            <label for="is_active" class="text-sm text-gray-700">Aktif</label>
        </div>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>

</div>
@endsection