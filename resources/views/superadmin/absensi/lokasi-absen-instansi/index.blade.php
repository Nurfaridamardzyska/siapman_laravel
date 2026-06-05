@extends('layouts.app')

@section('content')
<div class="p-6 space-y-4">

    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Lokasi Absen Instansi</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola pemetaan lokasi titik absen ke masing-masing instansi/unit kerja.</p>
        </div>
        <a href="{{ route('superadmin.absensi.lokasi-absen-instansi.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Lokasi
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold uppercase text-gray-600">No</th>
                        <th class="px-4 py-3 text-left font-semibold uppercase text-gray-600">Nama Lokasi</th>
                        <th class="px-4 py-3 text-left font-semibold uppercase text-gray-600">Koordinat</th>
                        <th class="px-4 py-3 text-left font-semibold uppercase text-gray-600">Radius</th>
                        <th class="px-4 py-3 text-left font-semibold uppercase text-gray-600">Unit Kerja</th>
                        <th class="px-4 py-3 text-left font-semibold uppercase text-gray-600">Status</th>
                        <th class="px-4 py-3 text-right font-semibold uppercase text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($items as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-3 text-gray-700">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800">
                                {{ $item->location->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 font-mono text-xs">
                                {{ $item->location->latitude ?? '-' }}, {{ $item->location->longitude ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                <span class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-semibold text-indigo-700 border border-indigo-200">
                                    {{ $item->location->radius_meters ?? '-' }} m
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $item->unit_name ?? '-' }}
                                @if($item->unit_id)
                                    <div class="text-[10px] text-gray-400">(ID: {{ $item->unit_id }})</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($item->location->is_active ?? false)
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-green-700 border border-green-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-600 border border-slate-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="https://www.google.com/maps?q={{ $item->location->latitude ?? 0 }},{{ $item->location->longitude ?? 0 }}"
                                       target="_blank"
                                       title="Buka di Google Maps"
                                       class="rounded-lg bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 border border-slate-200 transition-colors">
                                        🗺 Map
                                    </a>
                                    <a href="{{ route('superadmin.absensi.lokasi-absen-instansi.edit', $item->id) }}"
                                       class="rounded-lg bg-orange-50 px-3 py-1.5 text-xs font-semibold text-orange-600 hover:bg-orange-100 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('superadmin.absensi.lokasi-absen-instansi.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus pemetaan lokasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>Belum ada lokasi instansi yang terdaftar.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection