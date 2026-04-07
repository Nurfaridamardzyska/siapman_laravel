@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">
            Mesin Absensi
        </h1>

        {{-- Nanti link ini diganti ke route create mesin kalau CRUD sudah dibuat --}}
        <a href="#"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            + Tambah Mesin
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <div class="p-4">
            <p class="text-gray-600">
                Halaman <b>Mesin Absensi</b> sudah aktif. Silakan lanjutkan implementasi CRUD menggunakan tabel
                <b>attendance_machines</b>.
            </p>
        </div>
    </div>

</div>
@endsection