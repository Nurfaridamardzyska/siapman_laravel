<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-8">

        <!-- HEADER & FILTER -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-2xl shadow-sm border border-slate-200/60 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">
                    Monitoring Presensi
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    @if($unitKerja)
                        Unit Kerja/Instansi: <span class="font-medium text-slate-700">{{ $unitKerja }}</span>
                    @else
                        Semua Unit Kerja
                    @endif
                </p>
            </div>
            
            <form action="{{ route('admin.monitoring') }}" method="GET" class="flex gap-3 w-full sm:w-auto">
                <input type="month" name="month" value="{{ $selectedMonth }}" 
                       class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 w-full sm:w-48 outline-none transition-all"
                       onchange="this.form.submit()">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/20 transition-all flex items-center justify-center whitespace-nowrap shadow-sm shadow-blue-600/20">
                    Terapkan
                </button>
            </form>
        </div>

        <!-- STATS OVERVIEW -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- TOTAL KEHADIRAN -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm relative overflow-hidden group hover:border-blue-500/30 transition-colors">
                <div class="relative z-10">
                    <p class="text-slate-500 text-sm font-medium mb-1">Total Entri Presensi</p>
                    <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalData) }}</h3>
                    <p class="text-xs text-slate-400 mt-2 font-medium">Bulan {{ \Carbon\Carbon::parse($selectedMonth . '-01')->translatedFormat('F Y') }}</p>
                </div>
                <div class="absolute -right-4 -top-4 opacity-5 text-blue-600 group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <!-- PERHATIAN -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm flex items-center gap-5 hover:border-slate-300 transition-colors">
                <div class="w-14 h-14 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center shrink-0 border border-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-sm text-slate-500 font-medium tracking-wide">Pemantauan</h4>
                    <p class="text-xl font-bold text-slate-800 mt-0.5">{{ \Carbon\Carbon::parse($selectedMonth . '-01')->translatedFormat('M Y') }}</p>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm flex items-center gap-5 hover:border-slate-300 transition-colors">
                <div class="w-14 h-14 bg-emerald-50/50 text-emerald-500 rounded-2xl flex items-center justify-center shrink-0 border border-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <h4 class="text-sm text-slate-500 font-medium tracking-wide">Evaluasi</h4>
                    <p class="text-xl font-bold text-slate-800 mt-0.5">Visual</p>
                </div>
            </div>
        </div>

        <!-- TABLE DATA -->
        <div class="bg-white shadow-sm rounded-2xl border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200/60 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-lg">Riwayat Presensi</h3>
                <span class="text-xs px-3 py-1.5 bg-slate-50 border border-slate-200/60 text-slate-600 rounded-md font-medium tracking-wide">
                    {{ $data->count() }} Data Tertampil
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200/60">
                            <th class="px-6 py-4 font-semibold whitespace-nowrap">Tanggal</th>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap">Pegawai</th>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap text-center">Waktu Masuk</th>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap text-center">Waktu Keluar</th>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($data as $log)
                            <tr class="hover:bg-slate-50/50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($log->attendance_date)->translatedFormat('d M Y') }}</span>
                                        <span class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($log->attendance_date)->translatedFormat('l') }}</span>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="hidden sm:flex w-9 h-9 rounded-full bg-slate-100 text-slate-600 items-center justify-center font-bold text-xs ring-1 ring-slate-200/60">
                                            {{ substr($log->employee?->name ?? '?', 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">
                                                {{ $log->employee?->name ?? 'Data Terhapus' }}
                                            </p>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                NIP. {{ $log->employee?->nip ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg {{ $log->check_in_at ? 'bg-slate-50 text-slate-700 border border-slate-200/60' : 'text-slate-400' }}">
                                        <span class="text-sm font-medium">
                                            {{ $log->check_in_at ? \Carbon\Carbon::parse($log->check_in_at)->format('H:i') : '--:--' }}
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg {{ $log->check_out_at ? 'bg-slate-50 text-slate-700 border border-slate-200/60' : 'text-slate-400' }}">
                                        <span class="text-sm font-medium">
                                            {{ $log->check_out_at ? \Carbon\Carbon::parse($log->check_out_at)->format('H:i') : '--:--' }}
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        // Cleaner badge stylings
                                        if (isset($log->status)) {
                                            $statusText = $log->status->name;
                                            if (stripos($statusText, 'tepat waktu') !== false || stripos($statusText, 'hadir') !== false) {
                                                $badgeColor = 'bg-emerald-50 text-emerald-600 ring-1 ring-emerald-500/20';
                                            } elseif (stripos($statusText, 'terlambat') !== false) {
                                                $badgeColor = 'bg-amber-50 text-amber-600 ring-1 ring-amber-500/20';
                                            } else {
                                                $badgeColor = 'bg-blue-50 text-blue-600 ring-1 ring-blue-500/20';
                                            }
                                        } else {
                                            $statusText = $log->check_in_at ? 'Hadir' : 'Alpha';
                                            $badgeColor = $log->check_in_at ? 'bg-emerald-50 text-emerald-600 ring-1 ring-emerald-500/20' : 'bg-rose-50 text-rose-600 ring-1 ring-rose-500/20';
                                        }
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-semibold rounded-md {{ $badgeColor }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-50 flex items-center justify-center rounded-2xl mb-4 border border-slate-200/60">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <h3 class="text-slate-800 font-bold mb-1">Riwayat Kosong</h3>
                                        <p class="text-slate-500 text-sm max-w-sm mx-auto">Tidak ada presensi pada periode bulan ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- PAGINATION -->
            @if($data->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-white">
                    {{ $data->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
