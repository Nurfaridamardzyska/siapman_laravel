@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Jadwal Kerja</h1>

        <a href="{{ route('superadmin.absensi.jadwal-kerja.create', ['category_id' => $categoryId]) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            + Tambah Jadwal
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- FILTER KATEGORI --}}
    <div class="bg-white rounded-lg shadow p-4 mb-4">
        <form method="GET" action="{{ route('superadmin.absensi.jadwal-kerja.index') }}" class="flex items-end gap-3">
            <div class="w-80">
                <label class="text-sm text-gray-600">Kategori Jadwal</label>
                <select name="category_id" class="w-full mt-1 border rounded-lg p-2">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ (string)$categoryId === (string)$cat->id ? 'selected' : '' }}>
                            {{ $cat->name }} (Prioritas: {{ $cat->priority }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg">
                Tampilkan
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Hari</th>
                    <th class="p-3 text-left">Jam Masuk</th>
                    <th class="p-3 text-left">Jam Pulang</th>
                    <th class="p-3 text-left">Toleransi</th>
                    <th class="p-3 text-left">Menit Efektif</th>
                    <th class="p-3 text-left">Tipe Pegawai</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($items as $item)
                @php
                    $hari = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'][$item->day_of_week] ?? '-';
                @endphp
                <tr class="border-b">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3">{{ $hari }}</td>
                    <td class="p-3">{{ $item->start_time }}</td>
                    <td class="p-3">{{ $item->end_time }}</td>
                    <td class="p-3">{{ $item->tolerance_minutes ?? 0 }} menit</td>
                    <td class="p-3">{{ $item->effective_minutes ?? 0 }}</td>
                    <td class="p-3">{{ $item->employee_type ?? '-' }}</td>
                    <td class="p-3">
                        @if($item->is_active)
                            <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">Aktif</span>
                        @else
                            <span class="px-2 py-1 rounded bg-gray-200 text-gray-700 text-xs">Nonaktif</span>
                        @endif
                    </td>

                    {{-- ✅ AKSI --}}
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('superadmin.absensi.jadwal-kerja.edit', $item->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <form action="{{ route('superadmin.absensi.jadwal-kerja.destroy', $item->id) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="p-3 text-center text-gray-500">
                        Belum ada jadwal kerja untuk kategori ini.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection