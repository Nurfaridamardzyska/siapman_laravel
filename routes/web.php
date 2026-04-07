<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| CONTROLLER
|--------------------------------------------------------------------------
*/

// ADMIN
use App\Http\Controllers\Admin\AdminDashboardController;

// SUPERADMIN
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\PegawaiController;
use App\Http\Controllers\SuperAdmin\LaporanController;
use App\Http\Controllers\SuperAdmin\CompanyController;

// ABSENSI
use App\Http\Controllers\SuperAdmin\Absensi\WeeklyScheduleCategoryController;
use App\Http\Controllers\SuperAdmin\Absensi\WeeklyScheduleController;
use App\Http\Controllers\SuperAdmin\Absensi\CompanyLocationController;
use App\Http\Controllers\SuperAdmin\Absensi\UserDeviceController;
use App\Http\Controllers\SuperAdmin\Absensi\LocationController;
use App\Http\Controllers\SuperAdmin\Absensi\EmployeeLocationController;
use App\Http\Controllers\SuperAdmin\Absensi\MachineFaultController;
use App\Http\Controllers\SuperAdmin\Absensi\MachineController;
use App\Http\Controllers\SuperAdmin\Absensi\AttendanceLogController;

// MASTER / KONFIGURASI
use App\Http\Controllers\SuperAdmin\Master\DocumentTypeController;
use App\Http\Controllers\SuperAdmin\Master\EmployeeTypeController;
use App\Http\Controllers\SuperAdmin\Master\HolidayController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | KEPEGAWAIAN
        |--------------------------------------------------------------------------
        */

        Route::resource('pegawai', PegawaiController::class);

        Route::get('pegawai-wajah', [PegawaiController::class, 'wajah'])
            ->name('pegawai.wajah');

        Route::post('pegawai/{pegawai}/wajah', [PegawaiController::class, 'storeWajah'])
            ->name('pegawai.wajah.store');

        Route::delete('wajah/{face}', [PegawaiController::class, 'deleteWajah'])
            ->name('pegawai.wajah.delete');

        Route::patch('wajah/{face}/aktif', [PegawaiController::class, 'setAktif'])
            ->name('pegawai.wajah.aktif');

        Route::get('ketidakhadiran', [PegawaiController::class, 'ketidakhadiran'])
            ->name('pegawai.ketidakhadiran');

        Route::patch('ketidakhadiran/leave/{leave}', [PegawaiController::class, 'updateLeaveStatus'])
            ->name('pegawai.leave.update');

        Route::patch('ketidakhadiran/fault/{fault}', [PegawaiController::class, 'updateFaultStatus'])
            ->name('pegawai.fault.update');

        /*
        |--------------------------------------------------------------------------
        | PENGGUNA
        |--------------------------------------------------------------------------
        */

        Route::get('pengguna', [PegawaiController::class, 'pengguna'])
            ->name('pengguna.index');

        Route::get('pengguna/create', [PegawaiController::class, 'createPengguna'])
            ->name('pengguna.create');

        Route::post('pengguna', [PegawaiController::class, 'storePengguna'])
            ->name('pengguna.store');

        Route::get('pengguna/export', [PegawaiController::class, 'exportPengguna'])
            ->name('pengguna.export');

        Route::post('pengguna/import', [PegawaiController::class, 'importPengguna'])
            ->name('pengguna.import');

        Route::patch('pengguna/bulk-status', [PegawaiController::class, 'bulkStatus'])
            ->name('pengguna.bulk-status');

        Route::get('pengguna/{user}/edit', [PegawaiController::class, 'editPengguna'])
            ->name('pengguna.edit');

        Route::put('pengguna/{user}', [PegawaiController::class, 'updatePengguna'])
            ->name('pengguna.update');

        Route::patch('pengguna/{user}/reset', [PegawaiController::class, 'resetPassword'])
            ->name('pengguna.reset');

        Route::patch('pengguna/{user}/status', [PegawaiController::class, 'toggleStatus'])
            ->name('pengguna.status');

        Route::get('pengguna/{user}/riwayat-login', [PegawaiController::class, 'riwayatLogin'])
            ->name('pengguna.riwayat-login');

        Route::get('pengguna/{user}/perangkat', [PegawaiController::class, 'perangkat'])
            ->name('pengguna.perangkat');

        Route::get('pengguna/{user}/lokasi-absen', [PegawaiController::class, 'lokasiAbsen'])
            ->name('pengguna.lokasi-absen');

        Route::get('pengguna/{user}/detail-akses', [PegawaiController::class, 'detailAkses'])
            ->name('pengguna.detail-akses');

        Route::delete('pengguna/{user}', [PegawaiController::class, 'destroyPengguna'])
            ->name('pengguna.delete');

        /*
        |--------------------------------------------------------------------------
        | ABSENSI
        |--------------------------------------------------------------------------
        */

        Route::resource('absensi/kategori-jadwal-kerja', WeeklyScheduleCategoryController::class)
            ->names('absensi.kategori-jadwal-kerja');

        Route::resource('absensi/jadwal-kerja', WeeklyScheduleController::class)
            ->parameters(['jadwal-kerja' => 'jadwal_kerja'])
            ->names('absensi.jadwal-kerja');

        Route::resource('absensi/lokasi-absen-instansi', CompanyLocationController::class)
            ->parameters(['lokasi-absen-instansi' => 'lokasi_absen_instansi'])
            ->names('absensi.lokasi-absen-instansi');

        Route::resource('absensi/lokasi-absen', LocationController::class)
            ->parameters(['lokasi-absen' => 'lokasi_absen'])
            ->names('absensi.lokasi-absen');

        Route::resource('absensi/perangkat-pengguna', UserDeviceController::class)
            ->parameters(['perangkat-pengguna' => 'perangkat_pengguna'])
            ->names('absensi.perangkat-pengguna');

        /*
        |--------------------------------------------------------------------------
        | LOKASI ABSEN PEGAWAI
        |--------------------------------------------------------------------------
        */

        Route::get('absensi/lokasi-absen-pegawai', [EmployeeLocationController::class, 'index'])
            ->name('absensi.lokasi-absen-pegawai.index');

        Route::post('absensi/lokasi-absen-pegawai/bulk', [EmployeeLocationController::class, 'bulkStore'])
            ->name('absensi.lokasi-absen-pegawai.bulk');

        Route::get('absensi/lokasi-absen-pegawai/{employee}', [EmployeeLocationController::class, 'show'])
            ->name('absensi.lokasi-absen-pegawai.show');

        Route::post('absensi/lokasi-absen-pegawai', [EmployeeLocationController::class, 'store'])
            ->name('absensi.lokasi-absen-pegawai.store');

        /*
        |--------------------------------------------------------------------------
        | LAPOR KENDALA
        |--------------------------------------------------------------------------
        */

        Route::resource('absensi/lapor-kendala-absensi', MachineFaultController::class)
            ->parameters(['lapor-kendala-absensi' => 'lapor_kendala_absensi'])
            ->names('absensi.lapor-kendala-absensi');

        /*
        |--------------------------------------------------------------------------
        | MESIN
        |--------------------------------------------------------------------------
        */

        Route::get('absensi/mesin', [MachineController::class, 'index'])
            ->name('absensi.mesin.index');

        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PRESENSI
        |--------------------------------------------------------------------------
        */

        Route::get('absensi/riwayat-presensi', [AttendanceLogController::class, 'index'])
            ->name('absensi.riwayat-presensi.index');

        Route::get('absensi/riwayat-presensi/export', [AttendanceLogController::class, 'export'])
            ->name('absensi.riwayat-presensi.export');

        Route::get('absensi/riwayat-presensi/{attendance_log}', [AttendanceLogController::class, 'show'])
            ->name('absensi.riwayat-presensi.show');

        /*
        |--------------------------------------------------------------------------
        | LAPORAN
        |--------------------------------------------------------------------------
        */

        Route::get('laporan/presensi-harian', [LaporanController::class, 'presensiHarian'])
            ->name('laporan.presensi-harian');

        Route::get('laporan/presensi-bulanan', [LaporanController::class, 'presensiBulanan'])
            ->name('laporan.presensi-bulanan');

        /*
        |--------------------------------------------------------------------------
        | MASTER
        |--------------------------------------------------------------------------
        */

        Route::resource('master/tipe-dokumen', DocumentTypeController::class)
            ->names('master.tipe-dokumen');

        Route::resource('master/instansi', CompanyController::class)
            ->names('master.instansi');

        /*
        |--------------------------------------------------------------------------
        | KONFIGURASI
        |--------------------------------------------------------------------------
        */

        Route::resource('tipe-pegawai', EmployeeTypeController::class)
            ->except('show')
            ->names('tipe-pegawai');

        Route::resource('hari-libur', HolidayController::class)
            ->except('show')
            ->names('hari-libur');
    });

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats'])
        ->name('dashboard.stats');
    });

require __DIR__ . '/auth.php';