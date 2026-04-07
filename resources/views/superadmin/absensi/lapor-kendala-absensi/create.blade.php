@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Tambah Laporan Kendala</h1>
        <a href="{{ route('superadmin.absensi.lapor-kendala-absensi.index') }}"
           class="bg-gray-200 px-4 py-2 rounded">
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

    <form method="POST"
          action="{{ route('superadmin.absensi.lapor-kendala-absensi.store') }}"
          enctype="multipart/form-data"
          class="bg-white p-4 rounded shadow space-y-4">
        @csrf

        <div>
            <label class="text-sm text-gray-600">Jenis Kendala</label>
            <select name="machine_fault_type_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih --</option>
                @foreach($types as $t)
                    <option value="{{ $t->id }}" @selected(old('machine_fault_type_id')==$t->id)>
                        {{ $t->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm text-gray-600">Tanggal Kejadian</label>
            <input type="date" name="incident_date" value="{{ old('incident_date') }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="text-sm text-gray-600">Keterangan</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded px-3 py-2"
                      placeholder="Contoh: Mesin rusak / lupa absen / dll">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="text-sm text-gray-600">Upload Bukti (Foto)</label>
            <input type="file" name="evidence" accept="image/*"
                   class="w-full border rounded px-3 py-2">
            <p class="text-xs text-gray-500 mt-1">Max 4MB</p>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
</div>
@endsection