<div class="w-64 bg-gradient-to-b from-blue-600 to-blue-700 text-white min-h-screen p-5">

    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-xl font-bold tracking-wide">SIAPMAN</h2>
        <p class="text-xs opacity-80">Sistem Presensi ASN</p>
    </div>

    @php
        $user = auth()->user();
    @endphp

    {{-- MENU --}}
    <nav class="space-y-2 text-sm">

        {{-- DASHBOARD (DINAMIS SESUAI ROLE) --}}
        <a href="{{ $user->role === 'admin' ? route('admin.dashboard') : route('superadmin.dashboard') }}"
           class="block px-4 py-2 rounded-lg transition
           {{ request()->routeIs('admin.dashboard') || request()->routeIs('superadmin.dashboard') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">
            Dashboard
        </a>

        {{-- ================= ADMIN ================= --}}
        @if($user->role === 'admin')

            <a href="{{ route('admin.presensi') }}"
               class="block px-4 py-2 rounded-lg transition
               {{ request()->routeIs('admin.presensi') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">
                Data Presensi Pegawai
            </a>

            <a href="{{ route('admin.pegawai') }}"
               class="block px-4 py-2 rounded-lg transition
               {{ request()->routeIs('admin.pegawai') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">
                Data Pegawai
            </a>

            <a href="{{ route('admin.monitoring') }}"
               class="block px-4 py-2 rounded-lg transition
               {{ request()->routeIs('admin.monitoring') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">
                Monitoring Presensi
            </a>

        @endif


        {{-- ================= SUPERADMIN ================= --}}
        @if($user->role === 'superadmin')

            {{-- KONFIGURASI --}}
            <a href="{{ route('superadmin.tipe-pegawai.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-white/20">
                Tipe Pegawai
            </a>

            <a href="{{ route('superadmin.hari-libur.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-white/20">
                Hari Libur
            </a>

            {{-- MASTER --}}
            <a href="{{ route('superadmin.master.instansi.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-white/20">
                Instansi
            </a>

            {{-- ABSENSI --}}
            <a href="{{ route('superadmin.absensi.jadwal-kerja.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-white/20">
                Jadwal Kerja
            </a>

            <a href="{{ route('superadmin.absensi.riwayat-presensi.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-white/20">
                Riwayat Presensi
            </a>

        @endif


        {{-- USER INFO --}}
        <hr class="border-white/30 my-4">

        <div class="text-xs opacity-70">
            {{ $user->name }}
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