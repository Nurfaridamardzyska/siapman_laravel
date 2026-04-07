@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Lokasi Absen</h1>

        <a href="{{ route('superadmin.absensi.lokasi-absen.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            + Tambah Lokasi
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="bg-white p-4 rounded shadow mb-4 flex gap-3 items-end">
        <div class="flex-1">
            <label class="text-sm text-gray-600">Cari Lokasi</label>
            <input type="text" name="q" value="{{ $search }}"
                   class="w-full border rounded px-3 py-2"
                   placeholder="Nama lokasi...">
        </div>

        <div class="w-64">
            <label class="text-sm text-gray-600">OPD/Unit</label>
            <select name="unit_id" class="w-full border rounded px-3 py-2">
                <option value="">-- Semua --</option>
                @foreach($units ?? [] as $u)
                    <option value="{{ $u->id }}" @selected((string)$unitId === (string)$u->id)>
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="bg-gray-800 text-white px-4 py-2 rounded">Filter</button>

        <a href="{{ route('superadmin.absensi.lokasi-absen.index') }}"
           class="bg-gray-200 text-gray-800 px-4 py-2 rounded">
            Reset
        </a>
    </form>

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Nama Lokasi</th>
                    <th class="p-3 text-left">Koordinat</th>
                    <th class="p-3 text-left">Radius (m)</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($items as $item)
                <tr class="border-b">
                    <td class="p-3">{{ ($items->currentPage()-1) * $items->perPage() + $loop->iteration }}</td>

                    <td class="p-3">
                        <div class="font-semibold">{{ $item->name }}</div>
                        <div class="text-xs text-gray-500">Unit ID: {{ $item->unit_id ?? '-' }}</div>
                    </td>

                    <td class="p-3">
                        <div>{{ $item->latitude }}, {{ $item->longitude }}</div>
                    </td>

                    <td class="p-3">{{ $item->radius_meters }}</td>

                    <td class="p-3">
                        @if($item->is_active)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Aktif</span>
                        @else
                            <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">Nonaktif</span>
                        @endif
                    </td>

                    <td class="p-3 flex gap-2">
                        <a href="{{ route('superadmin.absensi.lokasi-absen.edit', $item->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('superadmin.absensi.lokasi-absen.destroy', $item->id) }}"
                              onsubmit="return confirm('Hapus lokasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-3 text-center text-gray-500">
                        Belum ada lokasi absen
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>

</div>
@endsection