<x-app-layout>
    <div class="p-6 space-y-6">

        <!-- HEADER -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Dashboard Admin
            </h2>
            <p class="text-sm text-gray-500">
                Unit Kerja: {{ $unit_kerja ?? '-' }}
            </p>
            <p class="text-xs text-gray-400">
                Server Time: {{ $server_time }}
            </p>
        </div>

        <!-- CARD STATS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div class="bg-white shadow rounded-xl p-4">
                <p class="text-sm text-gray-500">Total Pegawai</p>
                <p class="text-xl font-bold">{{ $total_pegawai }}</p>
            </div>

            <div class="bg-white shadow rounded-xl p-4">
                <p class="text-sm text-gray-500">User Aktif</p>
                <p class="text-xl font-bold text-green-600">{{ $user_aktif }}</p>
            </div>

            <div class="bg-white shadow rounded-xl p-4">
                <p class="text-sm text-gray-500">Hadir Hari Ini</p>
                <p class="text-xl font-bold text-blue-600">{{ $hadir_hari_ini }}</p>
            </div>

            <div class="bg-white shadow rounded-xl p-4">
                <p class="text-sm text-gray-500">Belum Presensi</p>
                <p class="text-xl font-bold text-red-600">{{ $belum_presensi }}</p>
            </div>

        </div>

        <!-- VALIDASI DFD -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="bg-yellow-100 border border-yellow-300 p-4 rounded-xl">
                <p class="text-sm text-yellow-700">Izin Pending</p>
                <p class="text-xl font-bold text-yellow-800">
                    {{ $izin_pending }}
                </p>
            </div>

            <div class="bg-red-100 border border-red-300 p-4 rounded-xl">
                <p class="text-sm text-red-700">Kendala Mesin Pending</p>
                <p class="text-xl font-bold text-red-800">
                    {{ $kendala_pending }}
                </p>
            </div>

        </div>

        <!-- AKSI CEPAT -->
        <div class="bg-white shadow rounded-xl p-4">
            <p class="font-semibold mb-2">Menu Cepat</p>

            <div class="flex gap-2 flex-wrap">

                <a href="{{ route('admin.presensi') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">
                    Lihat Presensi
                </a>

            </div>
        </div>

    </div>
</x-app-layout>