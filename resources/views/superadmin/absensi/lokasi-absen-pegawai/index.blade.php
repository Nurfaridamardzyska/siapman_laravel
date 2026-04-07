@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Lokasi Absen Pegawai (Override)</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="bg-white p-4 rounded shadow mb-4 flex gap-3 items-end">
        <div class="flex-1">
            <label class="text-sm text-gray-600">Cari Pegawai</label>
            <input type="text" name="q" value="{{ $search }}"
                   class="w-full border rounded px-3 py-2"
                   placeholder="Nama / NIP...">
        </div>

        <div class="w-64">
            <label class="text-sm text-gray-600">OPD/Unit</label>
            <select name="unit_id" class="w-full border rounded px-3 py-2">
                <option value="">-- Semua --</option>
                @foreach($units ?? [] as $u)
                    <option value="{{ $u->id }}" @selected((string)$unitId === (string)$u->id)>{{ $u->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
    </form>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">NIP</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                    <tr class="border-b">
                        <td class="p-3">{{ ($employees->currentPage()-1)*$employees->perPage() + $loop->iteration }}</td>
                        <td class="p-3">{{ $emp->nip ?? '-' }}</td>
                        <td class="p-3">{{ $emp->name }}</td>
                        <td class="p-3">
                            <a class="bg-indigo-600 text-white px-3 py-1 rounded"
                               href="{{ route('superadmin.absensi.lokasi-absen-pegawai.show', $emp->id) }}">
                                Kelola Lokasi
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-3 text-center text-gray-500" colspan="4">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $employees->links() }}
    </div>

</div>
@endsection