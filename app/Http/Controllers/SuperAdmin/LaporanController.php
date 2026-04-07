<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function presensiHarian(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();

        $employeeQuery = DB::table('employees');

        // Join companies hanya kalau tabel dan kolomnya ada
        if (
            Schema::hasTable('companies') &&
            Schema::hasColumn('employees', 'company_id')
        ) {
            $employeeQuery->leftJoin('companies', 'employees.company_id', '=', 'companies.id');
        }

        $selects = [
            'employees.id',
            'employees.name as employee_name',
        ];

        // NIP / nomor induk
        if (Schema::hasColumn('employees', 'employee_id_number')) {
            $selects[] = 'employees.employee_id_number';
        } elseif (Schema::hasColumn('employees', 'nip')) {
            $selects[] = 'employees.nip as employee_id_number';
        } else {
            $selects[] = DB::raw("'-' as employee_id_number");
        }

        // Jabatan sementara fallback
        $selects[] = DB::raw("'-' as position_name");

        // Unit kerja / OPD
        if (Schema::hasTable('companies') && Schema::hasColumn('employees', 'company_id')) {
            $selects[] = 'companies.name as company_name';
        } else {
            $selects[] = DB::raw("'-' as company_name");
        }

        $rows = $employeeQuery
            ->select($selects)
            ->orderBy('employees.name')
            ->get();

        $data = $rows->map(function ($row) use ($tanggal) {
            $logQuery = DB::table('attendance_logs')
                ->where('attendance_logs.employee_id', $row->id);

            // Pilih tanggal dari created_at kalau ada, kalau tidak pakai date
            if (Schema::hasColumn('attendance_logs', 'created_at')) {
                $logQuery->whereDate('attendance_logs.created_at', $tanggal)
                    ->orderBy('attendance_logs.created_at');
            } elseif (Schema::hasColumn('attendance_logs', 'date')) {
                $logQuery->whereDate('attendance_logs.date', $tanggal)
                    ->orderBy('attendance_logs.date');
            }

            // Join status kalau tabelnya ada
            if (
                Schema::hasTable('attendance_log_statuses') &&
                Schema::hasColumn('attendance_logs', 'status_id')
            ) {
                $logQuery->leftJoin(
                    'attendance_log_statuses',
                    'attendance_logs.status_id',
                    '=',
                    'attendance_log_statuses.id'
                );
            }

            // Join mesin kalau tabelnya ada
            if (
                Schema::hasTable('attendance_machines') &&
                Schema::hasColumn('attendance_logs', 'machine_id')
            ) {
                $logQuery->leftJoin(
                    'attendance_machines',
                    'attendance_logs.machine_id',
                    '=',
                    'attendance_machines.id'
                );
            }

            // Join lokasi kalau tabelnya ada
            if (
                Schema::hasTable('locations') &&
                Schema::hasColumn('attendance_logs', 'location_id')
            ) {
                $logQuery->leftJoin(
                    'locations',
                    'attendance_logs.location_id',
                    '=',
                    'locations.id'
                );
            }

            $logSelect = ['attendance_logs.*'];

            if (Schema::hasTable('attendance_log_statuses') && Schema::hasColumn('attendance_logs', 'status_id')) {
                $logSelect[] = 'attendance_log_statuses.name as status_name';
            } else {
                $logSelect[] = DB::raw("NULL as status_name");
            }

            if (Schema::hasTable('attendance_machines') && Schema::hasColumn('attendance_logs', 'machine_id')) {
                $logSelect[] = 'attendance_machines.name as machine_name';
            } else {
                $logSelect[] = DB::raw("NULL as machine_name");
            }

            if (Schema::hasTable('locations') && Schema::hasColumn('attendance_logs', 'location_id')) {
                $logSelect[] = 'locations.name as location_name';
            } else {
                $logSelect[] = DB::raw("NULL as location_name");
            }

            $logs = $logQuery->select($logSelect)->get();

            $firstLog = $logs->first();
            $lastLog = $logs->last();

            $jamMasuk = '-';
            $jamKeluar = '-';

            if ($firstLog) {
                $firstTime = $firstLog->created_at ?? $firstLog->date ?? null;
                if ($firstTime) {
                    $jamMasuk = Carbon::parse($firstTime)->format('H:i:s');
                }
            }

            if ($lastLog) {
                $lastTime = $lastLog->created_at ?? $lastLog->date ?? null;
                if ($lastTime) {
                    $jamKeluar = Carbon::parse($lastTime)->format('H:i:s');
                }
            }

            $durasiKerja = '-';
            if ($firstLog && $lastLog) {
                $start = $firstLog->created_at ?? $firstLog->date ?? null;
                $end = $lastLog->created_at ?? $lastLog->date ?? null;

                if ($start && $end) {
                    $startTime = Carbon::parse($start);
                    $endTime = Carbon::parse($end);

                    if ($endTime->greaterThan($startTime)) {
                        $minutes = $startTime->diffInMinutes($endTime);
                        $hours = floor($minutes / 60);
                        $mins = $minutes % 60;
                        $durasiKerja = sprintf('%02d:%02d', $hours, $mins);
                    }
                }
            }

            return (object) [
                'employee_id_number' => $row->employee_id_number ?? '-',
                'employee_name' => $row->employee_name ?? '-',
                'position_name' => $row->position_name ?? '-',
                'company_name' => $row->company_name ?? '-',
                'jam_masuk' => $jamMasuk,
                'jam_keluar' => $jamKeluar,
                'durasi_kerja' => $durasiKerja,
                'status' => $firstLog->status_name ?? ($firstLog ? 'Hadir' : 'Belum Ada Log'),
                'keterlambatan' => 0,
                'lokasi_mesin' => $firstLog->machine_name ?? $firstLog->location_name ?? '-',
                'ip_address' => $firstLog->ip_address ?? '-',
                'foto_capture' => null,
            ];
        });

        return view('superadmin.laporan.presensi-harian', compact('data', 'tanggal'));
    }

    public function presensiBulanan(Request $request)
    {
        return view('superadmin.laporan.presensi-bulanan');
    }
}