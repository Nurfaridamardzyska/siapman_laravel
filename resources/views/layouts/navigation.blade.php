<div class="w-64 bg-gradient-to-b from-blue-600 to-blue-700 text-white min-h-screen p-5">

    <div class="mb-8">
        <h2 class="text-xl font-bold tracking-wide">
            SIAPMAN
        </h2>
        <p class="text-xs opacity-80">
            Sistem Presensi ASN
        </p>
    </div>

    <nav class="space-y-2 text-sm">

        <a href="{{ route('dashboard') }}"
           class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
            Dashboard
        </a>

        @if(auth()->user()->role === 'superadmin')

            <a href="{{ route('superadmin.dashboard') }}"
               class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                Dashboard
            </a>

            <a href="{{ route('superadmin.pengguna.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                Manajemen Admin
            </a>

            {{-- DROPDOWN KEPEGAWAIAN --}}
            <div x-data="{ openKepegawaian: false }" class="mt-2">

                <button @click="openKepegawaian = !openKepegawaian"
                        class="w-full flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition">
                    <span>Kepegawaian</span>
                    <svg :class="{'rotate-180': openKepegawaian}"
                         class="w-4 h-4 transform transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="openKepegawaian"
                     x-transition
                     class="ml-4 mt-1 space-y-1">

                    <a href="{{ route('superadmin.pegawai.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Data Pegawai
                    </a>

                    <a href="{{ route('superadmin.pegawai.wajah') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Wajah Pegawai
                    </a>

                    <a href="{{ route('superadmin.pegawai.ketidakhadiran') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Dokumen Ketidakhadiran
                    </a>

                </div>
            </div>

            {{-- DROPDOWN ABSENSI --}}
            <div x-data="{ openAbsensi: false }" class="mt-2">

                <button @click="openAbsensi = !openAbsensi"
                        class="w-full flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition">
                    <span>Absensi</span>
                    <svg :class="{'rotate-180': openAbsensi}"
                         class="w-4 h-4 transform transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="openAbsensi"
                     x-transition
                     class="ml-4 mt-1 space-y-1">

                    <a href="{{ route('superadmin.absensi.jadwal-kerja.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Pengaturan Jam Absensi
                    </a>

                    <a href="{{ route('superadmin.absensi.lokasi-absen-instansi.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Lokasi Absen Instansi
                    </a>

                    <a href="{{ route('superadmin.absensi.lokasi-absen.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Lokasi Absen
                    </a>

                    <a href="{{ route('superadmin.absensi.lokasi-absen-pegawai.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Lokasi Absen Pegawai
                    </a>

                    <a href="{{ route('superadmin.absensi.perangkat-pengguna.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Perangkat Pengguna
                    </a>

                    <a href="{{ route('superadmin.absensi.mesin.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Mesin
                    </a>

                    <a href="{{ route('superadmin.absensi.lapor-kendala-absensi.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Lapor Kendala Absensi
                    </a>

                </div>
            </div>

            {{-- DROPDOWN LAPORAN --}}
            <div x-data="{ openLaporan: false }" class="mt-2">

                <button @click="openLaporan = !openLaporan"
                        class="w-full flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition">
                    <span>Laporan</span>
                    <svg :class="{'rotate-180': openLaporan}"
                         class="w-4 h-4 transform transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="openLaporan"
                     x-transition
                     class="ml-4 mt-1 space-y-1">

                    <a href="{{ route('superadmin.laporan.presensi-harian') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Presensi Harian
                    </a>

                    <a href="{{ route('superadmin.laporan.presensi-bulanan') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Presensi Bulanan
                    </a>

                </div>
            </div>

            {{-- DROPDOWN MASTER --}}
            <div x-data="{ openMaster: false }" class="mt-2">

                <button @click="openMaster = !openMaster"
                        class="w-full flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition">
                    <span>Master</span>
                    <svg :class="{'rotate-180': openMaster}"
                         class="w-4 h-4 transform transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="openMaster"
                     x-transition
                     class="ml-4 mt-1 space-y-1">

                    <a href="{{ route('superadmin.master.instansi.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Instansi
                    </a>

                    <a href="{{ route('superadmin.master.tipe-dokumen.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Tipe Dokumen
                    </a>

                    <a href="{{ route('superadmin.tipe-pegawai.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Tipe Pegawai
                    </a>

                    <a href="{{ route('superadmin.hari-libur.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Hari Libur
                    </a>

                </div>
            </div>

        @endif

        @if(auth()->user()->role === 'admin')
            <a href="#"
               class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                Monitoring ASN
            </a>
        @endif

        <hr class="border-white/30 my-4">

        <div class="text-xs opacity-70">
            {{ auth()->user()->name }}
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="mt-2 text-xs text-red-200 hover:text-white">
                Logout
            </button>
        </form>

    </nav>
</div>