@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Lokasi Absen Instansi</h1>

        <a href="{{ route('superadmin.absensi.lokasi-absen-instansi.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            + Tambah Lokasi
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Nama Lokasi</th>
                    <th class="p-3 text-left">Koordinat</th>
                    <th class="p-3 text-left">Radius</th>
                    <th class="p-3 text-left">Unit Kerja</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($items as $item)
                <tr class="border-b">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3">{{ $item->name }}</td>
                    <td class="p-3">{{ $item->latitude }}, {{ $item->longitude }}</td>
                    <td class="p-3">{{ $item->radius }} m</td>
                    <td class="p-3">{{ $item->companyLocation->unit_name ?? '-' }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('superadmin.absensi.lokasi-absen-instansi.edit', $item->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <form action="{{ route('superadmin.absensi.lokasi-absen-instansi.destroy', $item->id) }}"
                              method="POST" onsubmit="return confirm('Hapus lokasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded">
                                Hapus
                            </button>
                        </form>

                        <a class="bg-slate-600 text-white px-3 py-1 rounded"
                           target="_blank"
                           href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}">
                            Map
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-3 text-center text-gray-500">
                        Belum ada lokasi instansi
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection