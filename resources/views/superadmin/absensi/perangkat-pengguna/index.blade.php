@extends('layouts.app')

@section('content')
<div class="p-6">

<div class="flex justify-between mb-4">
<h1 class="text-2xl font-bold">Perangkat Pengguna</h1>

<a href="{{ route('superadmin.absensi.perangkat-pengguna.create') }}"
class="bg-blue-600 text-white px-4 py-2 rounded">
Tambah Perangkat
</a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
{{ session('success') }}
</div>
@endif

<div class="bg-white shadow rounded">

<table class="w-full text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-3">No</th>
<th class="p-3">User</th>
<th class="p-3">Device ID</th>
<th class="p-3">Tanggal</th>
<th class="p-3">Status</th>
<th class="p-3">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($items as $item)

<tr class="border-b">

<td class="p-3">{{ $loop->iteration }}</td>

<td class="p-3">
{{ $item->user->name ?? '-' }}
</td>

<td class="p-3">
{{ $item->device_id }}
</td>

<td class="p-3">
{{ $item->registered_at?->format('d-m-Y H:i') }}
</td>

<td class="p-3">
@if($item->is_active)
<span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
Aktif
</span>
@else
<span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">
Nonaktif
</span>
@endif
</td>

<td class="p-3 flex gap-2">

<a href="{{ route('superadmin.absensi.perangkat-pengguna.edit',$item->id) }}"
class="bg-yellow-500 text-white px-3 py-1 rounded">
Edit
</a>

<form method="POST"
action="{{ route('superadmin.absensi.perangkat-pengguna.destroy',$item->id) }}">
@csrf
@method('DELETE')

<button class="bg-red-600 text-white px-3 py-1 rounded">
Hapus
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="p-3 text-center text-gray-500">
Belum ada perangkat
</td>
</tr>

@endforelse

</tbody>
</table>

</div>
</div>
@endsection