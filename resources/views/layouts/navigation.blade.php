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
            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20">
                Pengaturan Presensi
            </a>

            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20">
                Manajemen Admin
            </a>
        @endif

        @if(auth()->user()->role === 'admin')
            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20">
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
