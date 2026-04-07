@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-100">
    <div class="border-b border-slate-200 bg-white px-6 py-4 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                <button class="text-sky-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div>
                    <h1 class="text-2xl font-bold uppercase tracking-wide text-sky-600">Dashboard</h1>
                    <p class="text-sm text-slate-500">Ringkasan operasional SIAPMAN</p>
                </div>
            </div>

            <div class="flex flex-col gap-3 md:flex-row md:items-center">
                <form method="GET" action="{{ route('superadmin.dashboard') }}" class="flex items-center gap-2">
                    <input
                        type="date"
                        name="tanggal"
                        value="{{ $tanggal }}"
                        class="rounded-xl border border-slate-300 px-4 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-100"
                    >
                    <button
                        type="submit"
                        class="rounded-xl bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700"
                    >
                        Terapkan
                    </button>
                </form>

                <div class="rounded-lg bg-sky-500 px-4 py-2 text-sm font-semibold text-white shadow">
                    DINAS KOMUNIKASI DAN INFORMATIKA
                </div>

                <div class="flex items-center gap-3 rounded-xl bg-white px-4 py-2 shadow-sm ring-1 ring-slate-200">
                    <span class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-200 text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 100 8 4 4 0 000-8zm-7 15a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-6 space-y-6">
        {{-- summary cards --}}
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-4">
            @foreach($summaryCards as $card)
                @php
                    $accentMap = [
                        'cyan' => 'border-cyan-300',
                        'sky' => 'border-sky-400',
                        'emerald' => 'border-emerald-400',
                        'indigo' => 'border-indigo-400',
                    ];
                @endphp

                <a href="{{ $card['route'] }}"
                   class="block rounded-xl border-l-4 {{ $accentMap[$card['accent']] ?? 'border-slate-300' }} bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <p class="text-sm font-bold uppercase tracking-wide text-sky-600">
                        {{ $card['title'] }}
                    </p>
                    <div class="mt-3 text-3xl font-extrabold leading-tight text-slate-700">
                        {{ $card['value'] }}
                    </div>
                    <p class="mt-2 text-sm text-slate-500">{{ $card['subtitle'] }}</p>
                </a>
            @endforeach
        </div>

        {{-- row 2 --}}
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="rounded-xl border-l-4 border-yellow-300 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xl font-bold uppercase tracking-wide text-sky-600">Koneksi Mesin ke Server</p>
                        <p class="mt-1 text-sm text-slate-500">
                            Online: {{ $mesinOnline }} • Offline: {{ $mesinOffline }}
                        </p>
                    </div>

                    <a href="{{ route('superadmin.absensi.mesin.index') }}"
                       class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        Kelola
                    </a>
                </div>

                <div class="mt-4 max-h-80 space-y-2 overflow-y-auto pr-1">
                    @forelse($machines as $machine)
                        <div class="flex items-center justify-between rounded-lg border border-slate-100 px-3 py-2 hover:bg-slate-50">
                            <span class="text-sm font-medium text-slate-700">{{ $machine['name'] }}</span>

                            @if($machine['status'])
                                <span class="text-sm font-semibold text-green-600">Terhubung ✓</span>
                            @else
                                <span class="text-sm font-semibold text-red-500">Tidak Terhubung ✖</span>
                            @endif
                        </div>
                    @empty
                        <div class="rounded-lg bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                            Belum ada data mesin.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-xl border-l-4 border-rose-300 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xl font-bold uppercase tracking-wide text-sky-600">Ringkasan Hari Ini</p>
                        <p class="mt-1 text-sm text-slate-500">Status operasional harian</p>
                    </div>

                    <a href="{{ route('superadmin.laporan.presensi-harian', ['tanggal' => $tanggal]) }}"
                       class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        Detail
                    </a>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-4">
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Hadir</p>
                        <p class="mt-2 text-2xl font-bold text-slate-800">{{ $hadirHariIni }}</p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Belum Presensi</p>
                        <p class="mt-2 text-2xl font-bold text-slate-800">{{ $belumPresensi }}</p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Terlambat</p>
                        <p class="mt-2 text-2xl font-bold text-slate-800">{{ $terlambatHariIni }}</p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Kendala Pending</p>
                        <p class="mt-2 text-2xl font-bold text-slate-800">{{ $pendingKendala }}</p>
                    </div>
                </div>

                <div class="mt-5 rounded-xl bg-blue-50 p-4">
                    <p class="text-xs uppercase tracking-wide text-blue-600">Hari Libur Terdekat</p>
                    @if($hariLiburTerdekat)
                        <p class="mt-2 text-sm font-semibold text-slate-800">{{ $hariLiburTerdekat->name }}</p>
                        <p class="text-sm text-slate-600">{{ \Carbon\Carbon::parse($hariLiburTerdekat->date)->format('d-m-Y') }}</p>
                    @else
                        <p class="mt-2 text-sm text-slate-500">Belum ada data hari libur.</p>
                    @endif
                </div>
            </div>

            <div class="rounded-xl border-l-4 border-emerald-300 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xl font-bold uppercase tracking-wide text-sky-600">Quick Access</p>
                        <p class="mt-1 text-sm text-slate-500">Akses cepat modul utama</p>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-3">
                    <a href="{{ route('superadmin.pegawai.index') }}"
                       class="rounded-xl bg-slate-50 p-4 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                        Data Pegawai
                    </a>

                    <a href="{{ route('superadmin.pengguna.index') }}"
                       class="rounded-xl bg-slate-50 p-4 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                        Data Pengguna
                    </a>

                    <a href="{{ route('superadmin.laporan.presensi-harian', ['tanggal' => $tanggal]) }}"
                       class="rounded-xl bg-slate-50 p-4 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                        Presensi Harian
                    </a>

                    <a href="{{ route('superadmin.laporan.presensi-bulanan') }}"
                       class="rounded-xl bg-slate-50 p-4 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                        Presensi Bulanan
                    </a>

                    <a href="{{ route('superadmin.absensi.riwayat-presensi.index') }}"
                       class="rounded-xl bg-slate-50 p-4 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                        Riwayat Presensi
                    </a>

                    <a href="{{ route('superadmin.hari-libur.index') }}"
                       class="rounded-xl bg-slate-50 p-4 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                        Hari Libur
                    </a>
                </div>
            </div>
        </div>

        {{-- row 3 --}}
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="rounded-xl bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">Presensi Terbaru Hari Ini</h2>
                        <p class="text-sm text-slate-500">Capture terbaru dari log kehadiran</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Nomor Induk</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($recentAttendances as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-sm font-medium text-slate-800">{{ $item->name }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $item->nip ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-sm text-slate-500">
                                        Belum ada log presensi hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">Belum Presensi</h2>
                        <p class="text-sm text-slate-500">Daftar ringkas pegawai yang belum tercatat hadir</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Nomor Induk</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($pegawaiBelumPresensi as $pegawai)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-sm font-medium text-slate-800">{{ $pegawai->name }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $pegawai->nip ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-8 text-center text-sm text-slate-500">
                                        Semua pegawai sudah tercatat atau data belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection