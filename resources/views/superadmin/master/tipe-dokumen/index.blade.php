@extends('layouts.app')

@section('content')
<div class="p-6">

<div class="flex justify-between mb-4">
    <h1 class="text-2xl font-bold">Master Tipe Dokumen</h1>

    <a href="{{ route('superadmin.master.tipe-dokumen.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded">
        Tambah Tipe Dokumen
    </a>
</div>

<div class="bg-white shadow rounded">
<table class="w-full text-sm">

<thead class="bg-gray-100">
<tr>
    <th class="p-3">No</th>
    <th class="p-3">Nama</th>
    <th class="p-3">Kode</th>
    <th class="p-3">Kategori</th>
    <th class="p-3">Approval</th>
    <th class="p-3">Status</th>
    <th class="p-3">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($items ?? [] as $item)
<tr class="border-b">
    <td class="p-3">{{ $loop->iteration }}</td>
    <td class="p-3">{{ $item->name }}</td>
    <td class="p-3">{{ $item->code }}</td>
    <td class="p-3">{{ $item->category }}</td>
    <td class="p-3">
        {{ $item->requires_approval ? 'Ya' : 'Tidak' }}
    </td>
    <td class="p-3">
        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
    </td>
    <td class="p-3 flex gap-2">

        <a href="{{ route('superadmin.master.tipe-dokumen.edit',$item->id) }}"
           class="bg-yellow-500 text-white px-3 py-1 rounded">
           Edit
        </a>

        <form method="POST"
              action="{{ route('superadmin.master.tipe-dokumen.destroy',$item->id) }}">
            @csrf
            @method('DELETE')

            <button class="bg-red-600 text-white px-3 py-1 rounded"
                onclick="return confirm('Hapus data ini?')">
                Hapus
            </button>
        </form>

    </td>
</tr>

@empty
<tr>
<td colspan="7" class="p-4 text-center text-gray-500">
Belum ada data tipe dokumen
</td>
</tr>
@endforelse

</tbody>

</table>
</div>

</div>
@endsection