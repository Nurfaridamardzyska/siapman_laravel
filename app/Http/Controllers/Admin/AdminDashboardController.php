<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AttendanceLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $data = $this->getDashboardStats();

        return view('admin.dashboard', $data);
    }

    public function stats()
    {
        return response()->json($this->getDashboardStats());
    }

    private function getDashboardStats(): array
    {
        $admin = auth()->user();
        $unitKerja = $admin->unit_kerja;
        $today = Carbon::today()->toDateString();

        $totalPegawai = User::where('role', 'user')
            ->when($unitKerja, function ($query) use ($unitKerja) {
                $query->where('unit_kerja', $unitKerja);
            })
            ->count();

        $userAktif = User::where('role', 'user')
            ->when($unitKerja, function ($query) use ($unitKerja) {
                $query->where('unit_kerja', $unitKerja);
            })
            ->where('status', 'aktif')
            ->count();

        $hadirHariIni = AttendanceLog::whereDate('attendance_date', $today)
            ->distinct('employee_id')
            ->count('employee_id');

        $belumPresensi = max($totalPegawai - $hadirHariIni, 0);

        return [
            'server_time' => now()->format('Y-m-d H:i:s'),
            'today_label' => Carbon::today()->format('Y-m-d'),
            'unit_kerja' => $unitKerja,
            'total_pegawai' => $totalPegawai,
            'user_aktif' => $userAktif,
            'hadir_hari_ini' => $hadirHariIni,
            'belum_presensi' => $belumPresensi,
        ];
    }
}