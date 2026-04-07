@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-lg font-semibold mb-4">
        Manajemen Wajah Pegawai
    </h2>

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Nama</th>
                <th class="p-2 border">NIP</th>
                <th class="p-2 border">Jumlah Wajah</th>
                <th class="p-2 border">Upload</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($employees as $emp)
        <tr class="text-center">
            <td class="p-2 border">{{ $emp->name }}</td>
            <td class="p-2 border">{{ $emp->nip }}</td>
            <td class="p-2 border">{{ $emp->faces->count() }}</td>

            <td class="p-2 border">
                <form method="POST"
                      action="{{ route('superadmin.pegawai.wajah.store',$emp->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="face_image" required>
                    <button class="bg-blue-600 text-white px-2 py-1 text-xs rounded">
                        Upload
                    </button>
                </form>
            </td>

            <td class="p-2 border">
                @foreach($emp->faces as $face)
                    <form method="POST"
                          action="{{ route('superadmin.pegawai.wajah.delete',$face->id) }}"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-2 py-1 text-xs rounded">
                            Hapus
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('superadmin.pegawai.wajah.aktif',$face->id) }}"
                          style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button class="bg-green-600 text-white px-2 py-1 text-xs rounded">
                            Aktifkan
                        </button>
                    </form>
                @endforeach
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

</div>
@endsection