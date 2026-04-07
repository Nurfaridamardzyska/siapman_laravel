@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-lg font-semibold mb-4">
        Dokumen Ketidakhadiran
    </h2>

    {{-- TAB BUTTON --}}
    <div class="flex space-x-4 mb-4">
        <button onclick="showTab('leave')" class="px-4 py-2 bg-blue-600 text-white rounded">
            Cuti & Izin
        </button>

        <button onclick="showTab('fault')" class="px-4 py-2 bg-gray-600 text-white rounded">
            Kendala Mesin
        </button>
    </div>

    {{-- TAB 1 --}}
    <div id="leaveTab">
        <h3 class="font-semibold mb-2">Daftar Cuti & Izin</h3>

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Jenis</th>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($leaves as $leave)
                <tr>
                    <td class="p-2 border">{{ $leave->employee->name }}</td>
                    <td class="p-2 border">{{ $leave->type->name ?? '-' }}</td>
                    <td class="p-2 border">
                        {{ $leave->start_date }} - {{ $leave->end_date }}
                    </td>
                    <td class="p-2 border">
                        {{ $leave->status->name ?? '-' }}
                    </td>
                    <td class="p-2 border">
                        <form method="POST"
                              action="{{ route('superadmin.pegawai.leave.update',$leave->id) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status_id" class="border text-xs">
                                <option value="2">Disetujui</option>
                                <option value="3">Ditolak</option>
                            </select>
                            <button class="bg-blue-600 text-white px-2 py-1 text-xs rounded">
                                Update
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- TAB 2 --}}
    <div id="faultTab" style="display:none;">
        <h3 class="font-semibold mb-2">Kendala Mesin</h3>

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Jenis</th>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($faults as $fault)
                <tr>
                    <td class="p-2 border">{{ $fault->employee->name }}</td>
                    <td class="p-2 border">{{ $fault->type->name ?? '-' }}</td>
                    <td class="p-2 border">{{ $fault->created_at }}</td>
                    <td class="p-2 border">
                        <form method="POST"
                              action="{{ route('superadmin.pegawai.fault.update',$fault->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="bg-green-600 text-white px-2 py-1 text-xs rounded">
                                Verifikasi
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
function showTab(type){
    document.getElementById('leaveTab').style.display =
        type === 'leave' ? 'block' : 'none';

    document.getElementById('faultTab').style.display =
        type === 'fault' ? 'block' : 'none';
}
</script>

@endsection
