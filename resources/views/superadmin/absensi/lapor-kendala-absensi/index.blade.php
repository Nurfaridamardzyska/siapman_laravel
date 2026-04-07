@extends('layouts.app')

@section('content')
<div class="p-6">

<div class="flex justify-between mb-4">
    <h1 class="text-2xl font-bold">Lapor Kendala Absensi</h1>

    <a href="{{ route('superadmin.absensi.lapor-kendala-absensi.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded">
        Tambah Laporan
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
        {{ session('success') }}
    </div>
@endif

<form method="GET" class="bg-white p-4 rounded shadow mb-4 grid grid-cols-4 gap-3 items-end">
    <div class="col-span-2">
        <label class="text-sm text-gray-600">Cari</label>
        <input type="text" name="q" value="{{ $q }}"
               class="w-full border rounded px-3 py-2"
               placeholder="Cari keterangan...">
    </div>

    <div>
        <label class="text-sm text-gray-600">Jenis</label>
        <select name="type_id" class="w-full border rounded px-3 py-2">
            <option value="">-- Semua --</option>
            @foreach($types as $t)
                <option value="{{ $t->id }}" @selected((string)$typeId===(string)$t->id)>{{ $t->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="text-sm text-gray-600">Status</label>
        <select name="status_id" class="w-full border rounded px-3 py-2">
            <option value="">-- Semua --</option>
            @foreach($statuses as $s)
                <option value="{{ $s->id }}" @selected((string)$statusId===(string)$s->id)>{{ $s->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-span-4">
        <button class="bg-gray-800 text-white px-4 py-2 rounded">Filter</button>
        <a href="{{ route('superadmin.absensi.lapor-kendala-absensi.index') }}" class="ml-2 text-sm underline">Reset</a>
    </div>
</form>

<div class="bg-white shadow rounded">
<table class="w-full text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">No</th>
            <th class="p-3">Jenis</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Status</th>
            <th class="p-3">Bukti</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($items as $item)
        <tr class="border-b">
            <td class="p-3">{{ $loop->iteration }}</td>
            <td class="p-3">{{ $item->type->name ?? '-' }}</td>
            <td class="p-3">{{ optional($item->incident_date)->format('d-m-Y') }}</td>
            <td class="p-3">{{ $item->status->name ?? '-' }}</td>
            <td class="p-3">
                @if($item->evidence_path)
                    <a class="text-blue-600 underline" target="_blank"
                       href="{{ asset('storage/'.$item->evidence_path) }}">Lihat</a>
                @else
                    -
                @endif
            </td>
            <td class="p-3 flex gap-2">
                <a href="{{ route('superadmin.absensi.lapor-kendala-absensi.edit', $item->id) }}"
                   class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>

                <form method="POST" action="{{ route('superadmin.absensi.lapor-kendala-absensi.destroy', $item->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 text-white px-3 py-1 rounded"
                            onclick="return confirm('Hapus laporan ini?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="p-3 text-center text-gray-500">Belum ada laporan</td>
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