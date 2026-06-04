<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\AttendanceLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'Dashboard berhasil diambil',
            'user' => $request->user(),
            'total_pegawai' => Employee::count(),
            'total_user' => User::count(),
        ]);
    }

    public function tppPercentage(Request $request)
    {
        $user = $request->user();
        $employee = $user->employee;

        if (!$employee) {
            return response()->json([
                'message' => 'Data pegawai tidak ditemukan',
                'data' => [
                    'total_hadir' => 0,
                    'total_late' => 0,
                    'total_alpha' => 0,
                    'total_tpp' => 0,
                    'total_potongan' => 0,
                    'hadir_percent' => 0,
                    'pengurangan_percent' => 0,
                ]
            ]);
        }

        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;
        $today = $now->day;

        // Hitung hari kerja yang sudah terlewati sampai hari ini (Senin-Jumat)
        $workingDaysToDate = 0;
        for ($d = 1; $d <= $today; $d++) {
            $date = Carbon::create($year, $month, $d);
            if (!$date->isWeekend()) {
                $workingDaysToDate++;
            }
        }
        
        // Total hari kerja dalam sebulan (untuk estimasi akhir)
        $totalWorkingDaysInMonth = 0;
        $daysInMonth = $now->daysInMonth;
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::create($year, $month, $d);
            if (!$date->isWeekend()) {
                $totalWorkingDaysInMonth++;
            }
        }

        // Ambil log kehadiran bulan ini
        $logs = AttendanceLog::where('employee_id', $employee->id)
            ->whereMonth('attendance_date', $month)
            ->whereYear('attendance_date', $year)
            ->get();

        $totalHadir = $logs->whereNotNull('check_in_at')->count();
        $totalLate = $logs->where('status_id', 2)->count();
        
        // Alpa hanya dihitung dari hari kerja yang sudah lewat dikurangi kehadiran/izin
        // (Untuk simulasi sederhana, kita gunakan workingDaysToDate)
        $totalAlpha = max(0, $workingDaysToDate - $totalHadir);

        $tppBase = $employee->tpp_allowance ?? 2000000;
        
        // Logika pengurangan: 5% per alpa, 1% per terlambat
        $reductionPercent = ($totalAlpha * 5) + ($totalLate * 1);
        $totalPotongan = ($tppBase * $reductionPercent) / 100;
        $totalTpp = max(0, $tppBase - $totalPotongan);

        $hadirPercent = $totalWorkingDaysInMonth > 0 
            ? min(100, ($totalHadir / $totalWorkingDaysInMonth) * 100) 
            : 0;

        return response()->json([
            'message' => 'Data TPP berhasil diambil',
            'data' => [
                'total_hadir' => $totalHadir,
                'total_late' => $totalLate,
                'total_alpha' => $totalAlpha,
                'total_tpp' => (int)$totalTpp,
                'total_potongan' => (int)$totalPotongan,
                'hadir_percent' => round($hadirPercent, 2),
                'pengurangan_percent' => round($reductionPercent, 2),
            ]
        ]);
    }
}