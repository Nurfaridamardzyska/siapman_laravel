@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Edit Lokasi Absen</h1>

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

    <form method="POST" action="{{ route('superadmin.absensi.lokasi-absen.update', $item->id) }}"
          class="bg-white p-4 rounded shadow space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="text-sm text-gray-600">OPD/Unit (opsional)</label>
            <select name="unit_id" class="w-full border rounded px-3 py-2">
                <option value="">-- Tidak ditentukan --</option>
                @foreach($units ?? [] as $u)
                    <option value="{{ $u->id }}" @selected((string)old('unit_id', $item->unit_id) === (string)$u->id)>
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm text-gray-600">Nama Lokasi</label>
            <input type="text" name="name" value="{{ old('name', $item->name) }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-sm text-gray-600">Latitude</label>
                <input type="number" step="0.0000001" name="latitude"
                       value="{{ old('latitude', $item->latitude) }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="text-sm text-gray-600">Longitude</label>
                <input type="number" step="0.0000001" name="longitude"
                       value="{{ old('longitude', $item->longitude) }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>
        </div>

        <div>
            <label class="text-sm text-gray-600">Radius (meter)</label>
            <input type="number" name="radius_meters"
                   value="{{ old('radius_meters', $item->radius_meters) }}"
                   class="w-full border rounded px-3 py-2" min="0" required>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" id="is_active"
                   @checked(old('is_active', $item->is_active))>
            <label for="is_active" class="text-sm text-gray-700">Aktif</label>
        </div>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>

</div>
@endsection