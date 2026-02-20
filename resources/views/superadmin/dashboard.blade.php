<x-app-layout>

    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-black rounded-2xl shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold mb-2">
            Dashboard Super Admin
        </h2>

        <p class="text-sm opacity-90">
            Selamat datang,
            <span class="font-semibold">
                {{ auth()->user()->name }}
            </span>
        </p>

        <span class="inline-block mt-3 px-3 py-1 text-xs bg-white/20 rounded-full">
            {{ ucfirst(auth()->user()->role) }}
        </span>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-semibold text-gray-700 mb-2">
                Manajemen Admin
            </h3>
            <p class="text-sm text-gray-500">
                Kelola akun admin OPD.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-semibold text-gray-700 mb-2">
                Konfigurasi Presensi
            </h3>
            <p class="text-sm text-gray-500">
                Atur jadwal dan aturan presensi ASN.
            </p>
        </div>
    </div>

</x-app-layout>
