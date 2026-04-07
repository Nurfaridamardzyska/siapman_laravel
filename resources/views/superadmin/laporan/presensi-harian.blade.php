@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Laporan Presensi Harian</h1>
            <p class="mt-1 text-sm text-slate-500">Rekap kehadiran pegawai per hari.</p>
        </div>
    </div>

    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('superadmin.laporan.presensi-harian') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit"
                    class="rounded-xl bg-blue-600 px-5 py-3 text-sm text-white hover:bg-blue-700">
                    Filter
                </button>

                <a href="{{ route('superadmin.laporan.presensi-harian') }}"
                    class="rounded-xl border border-slate-300 px-5 py-3 text-sm text-slate-700 hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-700">Data Presensi Harian</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">NIP / Nomor Induk</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Jabatan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Unit Kerja / OPD</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Jam Masuk</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Jam Keluar</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Durasi Kerja</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Keterlambatan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Lokasi / Mesin</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">IP / Device</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Foto Capture</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($data as $row)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $row->employee_id_number ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-slate-800">{{ $row->employee_name }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $row->position_name }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $row->company_name }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $row->jam_masuk }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $row->jam_keluar }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $row->durasi_kerja }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $row->status }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $row->keterlambatan }} menit</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $row->lokasi_mesin }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $row->ip_address }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">
                                @if($row->foto_capture)
                                    <a href="{{ $row->foto_capture }}" target="_blank" class="text-blue-600 hover:underline">
                                        Lihat
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="px-4 py-8 text-center text-sm text-slate-500">
                                Belum ada data presensi harian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection