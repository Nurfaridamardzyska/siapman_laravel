<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

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
| DASHBOARD (AUTO REDIRECT SESUAI ROLE)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {

    $role = Auth::user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($role === 'superadmin') {
        return redirect()->route('superadmin.dashboard');
    }

    return view('dashboard');

})->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // KEPEGAWAIAN
        Route::resource('pegawai', PegawaiController::class);

        Route::get('pegawai-wajah', [PegawaiController::class, 'wajah'])->name('pegawai.wajah');
        Route::post('pegawai/{pegawai}/wajah', [PegawaiController::class, 'storeWajah'])->name('pegawai.wajah.store');
        Route::delete('wajah/{face}', [PegawaiController::class, 'deleteWajah'])->name('pegawai.wajah.delete');
        Route::patch('wajah/{face}/aktif', [PegawaiController::class, 'setAktif'])->name('pegawai.wajah.aktif');

        Route::get('ketidakhadiran', [PegawaiController::class, 'ketidakhadiran'])->name('pegawai.ketidakhadiran');
        Route::patch('ketidakhadiran/leave/{leave}', [PegawaiController::class, 'updateLeaveStatus'])->name('pegawai.leave.update');
        Route::patch('ketidakhadiran/fault/{fault}', [PegawaiController::class, 'updateFaultStatus'])->name('pegawai.fault.update');

        Route::post('pegawai-wajah/sync-all', [PegawaiController::class, 'syncAllWajah'])
            ->name('pegawai.wajah.sync-all');

        /*
        --------------------------------------------------------------------------
        | PENGGUNA
        --------------------------------------------------------------------------
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

        // ABSENSI

        // ABSENSI
        Route::resource('absensi/kategori-jadwal-kerja', WeeklyScheduleCategoryController::class)
            ->names('absensi.kategori-jadwal-kerja');

        Route::resource('absensi/jadwal-kerja', WeeklyScheduleController::class)
            ->names('absensi.jadwal-kerja');

        Route::resource('absensi/lokasi-absen-instansi', CompanyLocationController::class)
            ->names('absensi.lokasi-absen-instansi');

        Route::resource('absensi/lokasi-absen', LocationController::class)
            ->names('absensi.lokasi-absen');

        Route::resource('absensi/perangkat-pengguna', UserDeviceController::class)
            ->names('absensi.perangkat-pengguna');

        // LOKASI ABSEN PEGAWAI
        Route::get('absensi/lokasi-absen-pegawai', [EmployeeLocationController::class, 'index'])
            ->name('absensi.lokasi-absen-pegawai.index');

        // KENDALA MESIN
        Route::resource('absensi/lapor-kendala-absensi', MachineFaultController::class)
            ->names('absensi.lapor-kendala-absensi');

        // MESIN
        Route::get('absensi/mesin', [MachineController::class, 'index'])
            ->name('absensi.mesin.index');

        // RIWAYAT PRESENSI
        Route::get('absensi/riwayat-presensi', [AttendanceLogController::class, 'index'])
            ->name('absensi.riwayat-presensi.index');

        // LAPORAN
        Route::get('laporan/presensi-harian', [LaporanController::class, 'presensiHarian'])
            ->name('laporan.presensi-harian');

        Route::get('laporan/presensi-bulanan', [LaporanController::class, 'presensiBulanan'])
            ->name('laporan.presensi-bulanan');

        // MASTER
        Route::resource('master/tipe-dokumen', DocumentTypeController::class)
            ->names('master.tipe-dokumen');

        Route::resource('master/instansi', CompanyController::class)
            ->names('master.instansi');

        // KONFIGURASI
        Route::resource('tipe-pegawai', EmployeeTypeController::class)->except('show');
        Route::resource('hari-libur', HolidayController::class)->except('show');
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

        Route::get('/presensi', [AdminDashboardController::class, 'presensi'])
            ->name('presensi');

        Route::get('/pegawai', [AdminDashboardController::class, 'pegawai'])
            ->name('pegawai');

        Route::get('/monitoring', [AdminDashboardController::class, 'monitoring'])
            ->name('monitoring');
    });

require __DIR__ . '/auth.php';