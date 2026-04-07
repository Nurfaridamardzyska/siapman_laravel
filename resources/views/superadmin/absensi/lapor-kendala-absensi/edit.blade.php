@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Edit Laporan Kendala</h1>
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
          action="{{ route('superadmin.absensi.lapor-kendala-absensi.update', $item->id) }}"
          enctype="multipart/form-data"
          class="bg-white p-4 rounded shadow space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-sm text-gray-600">Jenis Kendala</label>
                <select name="machine_fault_type_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($types as $t)
                        <option value="{{ $t->id }}"
                            @selected((string)old('machine_fault_type_id', $item->machine_fault_type_id)===(string)$t->id)>
                            {{ $t->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Status</label>
                <select name="machine_fault_status_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($statuses as $s)
                        <option value="{{ $s->id }}"
                            @selected((string)old('machine_fault_status_id', $item->machine_fault_status_id)===(string)$s->id)>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="text-sm text-gray-600">Tanggal Kejadian</label>
            <input type="date" name="incident_date"
                   value="{{ old('incident_date', optional($item->incident_date)->format('Y-m-d')) }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="text-sm text-gray-600">Keterangan</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded px-3 py-2">{{ old('description', $item->description) }}</textarea>
        </div>

        <div>
            <label class="text-sm text-gray-600">Ganti Bukti (opsional)</label>
            <input type="file" name="evidence" accept="image/*"
                   class="w-full border rounded px-3 py-2">
            @if($item->evidence_path)
                <p class="text-xs text-gray-600 mt-2">
                    Bukti saat ini:
                    <a target="_blank" class="text-blue-600 underline"
                       href="{{ asset('storage/'.$item->evidence_path) }}">Lihat</a>
                </p>
            @endif
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>
</div>
@endsection
