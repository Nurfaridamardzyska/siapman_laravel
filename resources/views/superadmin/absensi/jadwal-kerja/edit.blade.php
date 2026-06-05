@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Edit Jadwal Kerja</h1>

        <a href="{{ route('superadmin.absensi.jadwal-kerja.index', ['category_id' => $item->category_id]) }}"
           class="text-sm text-blue-600 hover:underline">
            ← Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('superadmin.absensi.jadwal-kerja.update', $item->id) }}"
          class="bg-white rounded-lg shadow p-5 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="text-sm text-gray-600">Kategori Jadwal</label>
            <select name="category_id" class="w-full mt-1 border rounded-lg p-2" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (string) old('category_id', $item->category_id) === (string) $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm text-gray-600">Hari</label>
            <select name="day_of_week" class="w-full mt-1 border rounded-lg p-2" required>
                @for($i=1;$i<=7;$i++)
                    @php $hari=[1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'][$i]; @endphp
                    <option value="{{ $i }}" {{ (string)old('day_of_week', $item->day_of_week) === (string)$i ? 'selected' : '' }}>
                        {{ $hari }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-sm text-gray-600">Jam Masuk</label>
                <input type="time" name="start_time" value="{{ old('start_time', $item->start_time) }}"
                       class="w-full mt-1 border rounded-lg p-2" required>
            </div>

            <div>
                <label class="text-sm text-gray-600">Jam Pulang</label>
                <input type="time" name="end_time" value="{{ old('end_time', $item->end_time) }}"
                       class="w-full mt-1 border rounded-lg p-2" required>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-sm text-gray-600">Toleransi (menit)</label>
                <input type="number" name="tolerance_minutes" value="{{ old('tolerance_minutes', $item->tolerance_minutes) }}"
                       class="w-full mt-1 border rounded-lg p-2" min="0">
            </div>

            <div>
                <label class="text-sm text-gray-600">Menit Efektif</label>
                <input type="number" name="effective_minutes" value="{{ old('effective_minutes', $item->effective_minutes) }}"
                       class="w-full mt-1 border rounded-lg p-2" min="0">
            </div>
        </div>

        <div>
            <label class="text-sm text-gray-600">Tipe Pegawai (opsional)</label>
            <input type="text" name="employee_type" value="{{ old('employee_type', $item->employee_type) }}"
                   class="w-full mt-1 border rounded-lg p-2">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
            <span class="text-sm text-gray-700">Aktif</span>
        </div>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Update
        </button>
    </form>
</div>
@endsection