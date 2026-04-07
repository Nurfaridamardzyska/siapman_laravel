@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Monitor Mesin</h1>

        {{-- nanti kalau mau CRUD mesin --}}
        {{-- <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Mesin</a> --}}
    </div>

    <form method="GET" class="bg-white p-4 rounded shadow mb-4 grid grid-cols-4 gap-3 items-end">
        <div class="col-span-2">
            <label class="text-sm text-gray-600">Cari</label>
            <input type="text" name="q" value="{{ $q }}"
                   class="w-full border rounded px-3 py-2"
                   placeholder="Nama / IP / Serial / Lokasi...">
        </div>

        <div>
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

        <div class="flex gap-2">
            <button class="bg-gray-800 text-white px-4 py-2 rounded">Filter</button>
            <a href="{{ route('superadmin.absensi.mesin.index') }}" class="text-sm underline self-center">Reset</a>
        </div>
    </form>

    <div class="bg-white shadow rounded">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">No</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Serial</th>
                    <th class="p-3">IP</th>
                    <th class="p-3">Lokasi</th>
                    <th class="p-3">Last Seen</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    @php
                        $online = $item->last_seen_at && now()->diffInMinutes($item->last_seen_at) <= 2;
                    @endphp
                    <tr class="border-b">
                        <td class="p-3">{{ $loop->iteration + ($items->currentPage()-1)*$items->perPage() }}</td>
                        <td class="p-3">{{ $item->name }}</td>
                        <td class="p-3">{{ $item->serial_number ?? '-' }}</td>
                        <td class="p-3">{{ $item->ip_address ?? '-' }}</td>
                        <td class="p-3">{{ $item->location_name ?? '-' }}</td>
                        <td class="p-3">{{ $item->last_seen_at?->format('d-m-Y H:i:s') ?? '-' }}</td>
                        <td class="p-3">
                            @if(!$item->is_active)
                                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">Nonaktif</span>
                            @else
                                @if($online)
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Online</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Offline</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-3 text-center text-gray-500">Belum ada data mesin</td>
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