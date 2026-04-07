@extends('layouts.app')

@section('content')

<div class="p-6">

<h1 class="text-2xl font-bold mb-4">
Instansi / OPD
</h1>

<a href="{{ route('superadmin.master.instansi.create') }}"
class="bg-blue-600 text-white px-4 py-2 rounded">
+ Tambah Instansi
</a>

<div class="bg-white mt-4 rounded shadow">

<table class="w-full">

<thead class="bg-gray-100">
<tr>
<th class="p-3">No</th>
<th class="p-3">Nama</th>
<th class="p-3">Kode</th>
<th class="p-3">Singkatan</th>
<th class="p-3">Tipe</th>
<th class="p-3">Status</th>
<th class="p-3">Aksi</th>
</tr>
</thead>

<tbody>

@foreach($companies as $company)

<tr class="border-b">
<td class="p-3">{{ $loop->iteration }}</td>
<td class="p-3">{{ $company->name }}</td>
<td class="p-3">{{ $company->kode_opd }}</td>
<td class="p-3">{{ $company->short_name }}</td>
<td class="p-3">{{ $company->type }}</td>
<td class="p-3">
{{ $company->is_active ? 'Aktif' : 'Nonaktif' }}
</td>

<td class="p-3 flex gap-2">

<a href="{{ route('superadmin.company.edit',$company->id) }}"
class="bg-yellow-500 text-white px-2 py-1 rounded">
Edit
</a>

<form method="POST"
action="{{ route('superadmin.company.destroy',$company->id) }}">
@csrf
@method('DELETE')

<button class="bg-red-500 text-white px-2 py-1 rounded">
Hapus
</button>

</form>

</td>
</tr>

@endforeach

</tbody>
</table>

</div>

</div>

@endsection