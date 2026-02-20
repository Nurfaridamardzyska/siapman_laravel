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

            <a href="#"
               class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                Pengaturan Presensi
            </a>

            <a href="#"
               class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                Manajemen Admin
            </a>

            {{-- DROPDOWN KEPEGAWAIAN --}}
            <div x-data="{ open: false }" class="mt-2">

                <button @click="open = !open"
                        class="w-full flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition">
                    <span>Kepegawaian</span>
                    <svg :class="{'rotate-180': open}"
                         class="w-4 h-4 transform transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open"
                     x-transition
                     class="ml-4 mt-1 space-y-1">

                    <a href="{{ route('pegawai.index') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Data Pegawai
                    </a>

                    <a href="{{ route('pegawai.wajah') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Wajah Pegawai
                    </a>

                    <a href="{{ route('pegawai.dokumen') }}"
                       class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">
                        Dokumen Ketidakhadiran
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