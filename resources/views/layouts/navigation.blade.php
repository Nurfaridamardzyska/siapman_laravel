<div class="w-64 bg-gradient-to-b from-blue-600 to-blue-700 text-white min-h-screen p-5">

    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-xl font-bold tracking-wide">SIAPMAN</h2>
        <p class="text-xs opacity-80">Sistem Presensi ASN</p>
    </div>

    {{-- MENU --}}
    <nav class="space-y-2 text-sm">

        {{-- DASHBOARD --}}
        <a href="{{ route('superadmin.dashboard') }}"
           class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">
            Dashboard
        </a>

        {{-- MENU SUPERADMIN --}}
        @if(auth()->user()->role === 'superadmin')

            {{-- DROPDOWN KONFIGURASI --}}
            <div
                x-data="{
                    openKonfigurasi: {{ request()->routeIs('superadmin.tipe-pegawai.*') || request()->routeIs('superadmin.hari-libur.*') ? 'true' : 'false' }}
                }"
                class="mt-2"
            >
                <button @click="openKonfigurasi = !openKonfigurasi"
                        class="w-full flex justify-between items-center px-4 py-2 text-white rounded-lg transition hover:bg-white/20">
                    <span>KONFIGURASI</span>

                    <svg :class="{ 'rotate-180': openKonfigurasi }"
                         class="w-4 h-4 transform transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="openKonfigurasi" x-transition class="mt-2">
                    <div class="bg-white rounded-md mx-3 p-2 shadow space-y-1 text-gray-700">

                        <a href="{{ route('superadmin.tipe-pegawai.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.tipe-pegawai.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Tipe Pegawai
                        </a>

                        <a href="{{ route('superadmin.hari-libur.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.hari-libur.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Hari Libur
                        </a>

                    </div>
                </div>
            </div>

            {{-- DROPDOWN MASTER --}}
            <div
                x-data="{
                    openMaster: {{ request()->routeIs('superadmin.master.*') ? 'true' : 'false' }}
                }"
                class="mt-2"
            >
                <button @click="openMaster = !openMaster"
                        class="w-full flex justify-between items-center px-4 py-2 text-white rounded-lg transition hover:bg-white/20">
                    <span>MASTER</span>

                    <svg :class="{ 'rotate-180': openMaster }"
                         class="w-4 h-4 transform transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="openMaster" x-transition class="mt-2">
                    <div class="bg-white rounded-md mx-3 p-2 shadow space-y-1 text-gray-700">

                        <a href="{{ route('superadmin.master.tipe-dokumen.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.master.tipe-dokumen.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Tipe Dokumen
                        </a>

                        <a href="{{ route('superadmin.master.instansi.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.master.instansi.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Instansi / OPD
                        </a>

                    </div>
                </div>
            </div>

            {{-- DROPDOWN ABSENSI --}}
            <div
                x-data="{
                    openAbsensi: {{ request()->routeIs('superadmin.absensi.*') ? 'true' : 'false' }}
                }"
                class="mt-2"
            >
                <button @click="openAbsensi = !openAbsensi"
                        class="w-full flex justify-between items-center px-4 py-2 text-white rounded-lg transition hover:bg-white/20">
                    <span>ABSENSI</span>

                    <svg :class="{ 'rotate-180': openAbsensi }"
                         class="w-4 h-4 transform transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="openAbsensi" x-transition class="mt-2">
                    <div class="bg-white rounded-md mx-3 p-2 shadow space-y-1 text-gray-700">

                        <a href="{{ route('superadmin.absensi.kategori-jadwal-kerja.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.absensi.kategori-jadwal-kerja.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Kategori Jadwal Kerja
                        </a>

                        <a href="{{ route('superadmin.absensi.jadwal-kerja.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.absensi.jadwal-kerja.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Jadwal Kerja
                        </a>

                        <a href="{{ route('superadmin.absensi.lokasi-absen-instansi.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.absensi.lokasi-absen-instansi.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Lokasi Absen Instansi
                        </a>

                        <a href="{{ route('superadmin.absensi.perangkat-pengguna.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.absensi.perangkat-pengguna.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Perangkat Pengguna
                        </a>

                        <a href="{{ route('superadmin.absensi.lokasi-absen-pegawai.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.absensi.lokasi-absen-pegawai.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Lokasi Absen Pegawai
                        </a>

                        <a href="{{ route('superadmin.absensi.lokasi-absen.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.absensi.lokasi-absen.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Lokasi Absen
                        </a>

                        <a href="{{ route('superadmin.absensi.lapor-kendala-absensi.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.absensi.lapor-kendala-absensi.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Lapor Kendala Absensi
                        </a>

                        <a href="{{ route('superadmin.absensi.riwayat-presensi.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.absensi.riwayat-presensi.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Riwayat Presensi
                        </a>

                        <a href="{{ route('superadmin.absensi.mesin.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.absensi.mesin.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Mesin
                        </a>

                    </div>
                </div>
            </div>

           {{-- KEPEGAWAIAN --}}
<div
    x-data="{
        openKepegawaian: {{ request()->routeIs('superadmin.pegawai.*') ? 'true' : 'false' }}
    }"
    class="mt-2"
>
    <button @click="openKepegawaian = !openKepegawaian"
            class="w-full flex justify-between items-center px-4 py-2 rounded-lg transition hover:bg-white/20">

        <span>KEPEGAWAIAN</span>

        <svg :class="{ 'rotate-180': openKepegawaian }"
             class="w-4 h-4 transform transition-transform duration-300"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="openKepegawaian" x-transition class="mt-2">
        <div class="bg-white rounded-md mx-3 p-2 shadow space-y-1 text-gray-700">

            <a href="{{ route('superadmin.pegawai.index') }}"
               class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.pegawai.index') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                Data Pegawai
            </a>

            <a href="{{ route('superadmin.pegawai.wajah') }}"
               class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.pegawai.wajah') || request()->routeIs('superadmin.pegawai.wajah.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                Wajah Pegawai
            </a>

            <a href="{{ route('superadmin.pegawai.ketidakhadiran') }}"
               class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.pegawai.ketidakhadiran') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                Dokumen Ketidakhadiran
            </a>

        </div>
    </div>
</div>

            {{-- DROPDOWN PENGGUNA --}}
            <div
                x-data="{
                    openPengguna: {{ request()->routeIs('superadmin.pengguna.*') ? 'true' : 'false' }}
                }"
                class="mt-2"
            >
                <button @click="openPengguna = !openPengguna"
                        class="w-full flex justify-between items-center px-4 py-2 rounded-lg transition hover:bg-white/20">

                    <span>PENGGUNA</span>

                    <svg :class="{ 'rotate-180': openPengguna }"
                         class="w-4 h-4 transform transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="openPengguna" x-transition class="mt-2">
                    <div class="bg-white rounded-md mx-3 p-2 shadow space-y-1 text-gray-700">

                        <a href="{{ route('superadmin.pengguna.index') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.pengguna.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Data Pengguna
                        </a>

                    </div>
                </div>
            </div>

            {{-- DROPDOWN LAPORAN --}}
            <div
                x-data="{
                    openLaporan: {{ request()->routeIs('superadmin.laporan.*') ? 'true' : 'false' }}
                }"
                class="mt-2"
            >
                <button @click="openLaporan = !openLaporan"
                        class="w-full flex justify-between items-center px-4 py-2 rounded-lg transition hover:bg-white/20">

                    <span>LAPORAN</span>

                    <svg :class="{ 'rotate-180': openLaporan }"
                         class="w-4 h-4 transform transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="openLaporan" x-transition class="mt-2">
                    <div class="bg-white rounded-md mx-3 p-2 shadow space-y-1 text-gray-700">

                        <a href="{{ route('superadmin.laporan.presensi-harian') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.laporan.presensi-harian') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Presensi Harian
                        </a>

                        <a href="{{ route('superadmin.laporan.presensi-bulanan') }}"
                           class="block px-3 py-2 rounded transition {{ request()->routeIs('superadmin.laporan.presensi-bulanan') ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
                            Presensi Bulanan
                        </a>

                    </div>
                </div>
            </div>

        @endif

        {{-- USER INFO --}}
        <hr class="border-white/30 my-4">

        <div class="text-xs opacity-70">
            {{ auth()->user()->name }}
        </div>

        {{-- LOGOUT --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="mt-2 text-xs text-red-200 hover:text-white">
                Logout
            </button>
        </form>

    </nav>
</div>