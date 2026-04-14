<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AttendanceLog;
use App\Models\EmployeeWorkLeave;
use App\Models\MachineFault;
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

    // 🔥 TAMBAHAN: HALAMAN PRESENSI ADMIN
    public function presensi()
    {
        $admin = auth('web')->user();
        $unitKerja = $admin?->unit_kerja;
        $today = Carbon::today()->toDateString();

        $data = AttendanceLog::with('employee')
            ->whereDate('attendance_date', $today)
            ->when($unitKerja, function ($query) use ($unitKerja) {
                $query->whereHas('employee', function ($q) use ($unitKerja) {
                    $q->where('unit_kerja', $unitKerja);
                });
            })
            ->get();

        return view('admin.presensi', compact('data', 'today'));
    }

    // 🔥 TAMBAHAN: HALAMAN DATA PEGAWAI
    public function pegawai()
    {
        $admin = auth('web')->user();
        $unitKerja = $admin?->unit_kerja;

        $pegawai = User::with('employee.position', 'employee.department')
            ->where('role', 'user')
            ->when($unitKerja, function ($query) use ($unitKerja) {
                $query->where('unit_kerja', $unitKerja);
            })
            ->get();

        return view('admin.pegawai', compact('pegawai', 'unitKerja'));
    }

    // 🔥 TAMBAHAN: HALAMAN MONITORING PRESENSI
    public function monitoring(Request $request)
    {
        $admin = auth('web')->user();
        $unitKerja = $admin?->unit_kerja;

        $selectedMonth = $request->get('month', Carbon::now()->format('Y-m'));
        $year = substr($selectedMonth, 0, 4);
        $month = substr($selectedMonth, 5, 2);

        $query = AttendanceLog::with(['employee', 'status'])
            ->whereYear('attendance_date', $year)
            ->whereMonth('attendance_date', $month)
            ->when($unitKerja, function ($q) use ($unitKerja) {
                $q->whereHas('employee', function ($u) use ($unitKerja) {
                    $u->where('unit_kerja', $unitKerja);
                });
            });

        $totalData = (clone $query)->count();
        $data = $query->orderBy('attendance_date', 'desc')->paginate(15)->withQueryString();

        return view('admin.monitoring', compact('data', 'selectedMonth', 'totalData', 'unitKerja'));
    }

    private function getDashboardStats(): array
    {
        $admin = auth('web')->user();
        $unitKerja = $admin?->unit_kerja;
        $today = Carbon::today()->toDateString();

        // 🔹 TOTAL PEGAWAI
        $totalPegawai = User::where('role', 'user')
            ->when($unitKerja, function ($query) use ($unitKerja) {
                $query->where('unit_kerja', $unitKerja);
            })
            ->count();

        // 🔹 USER AKTIF
        $userAktif = User::where('role', 'user')
            ->when($unitKerja, function ($query) use ($unitKerja) {
                $query->where('unit_kerja', $unitKerja);
            })
            ->where('status', 'aktif')
            ->count();

        // 🔹 HADIR HARI INI
        $hadirHariIni = AttendanceLog::whereDate('attendance_date', $today)
            ->whereHas('employee', function ($q) use ($unitKerja) {
                if ($unitKerja) {
                    $q->where('unit_kerja', $unitKerja);
                }
            })
            ->distinct('employee_id')
            ->count('employee_id');

        // 🔹 BELUM PRESENSI
        $belumPresensi = max($totalPegawai - $hadirHariIni, 0);

        // 🔥 VALIDASI IZIN
        $izinPending = EmployeeWorkLeave::where('status', 'pending')
            ->whereHas('employee', function ($q) use ($unitKerja) {
                if ($unitKerja) {
                    $q->where('unit_kerja', $unitKerja);
                }
            })
            ->count();

        // 🔥 VALIDASI KENDALA MESIN
        $kendalaPending = MachineFault::where('status', 'pending')
            ->whereHas('employee', function ($q) use ($unitKerja) {
                if ($unitKerja) {
                    $q->where('unit_kerja', $unitKerja);
                }
            })
            ->count();

        return [
            'server_time' => now()->format('Y-m-d H:i:s'),
            'today_label' => Carbon::today()->format('Y-m-d'),
            'unit_kerja' => $unitKerja,

            // MONITORING
            'total_pegawai' => $totalPegawai,
            'user_aktif' => $userAktif,
            'hadir_hari_ini' => $hadirHariIni,
            'belum_presensi' => $belumPresensi,

            // VALIDASI
            'izin_pending' => $izinPending,
            'kendala_pending' => $kendalaPending,
        ];
    }
}