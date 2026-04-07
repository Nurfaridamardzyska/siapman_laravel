@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="admin-dashboard-header mb-4">
        <div>
            <h2 class="admin-title mb-1">Dashboard Admin</h2>
            <p class="admin-subtitle mb-0">Ringkasan operasional unit kerja</p>
        </div>
        <div class="text-end">
            <div class="live-badge">Realtime</div>
            <div id="liveClock" class="live-clock mt-2">{{ $server_time }}</div>
            <small class="text-muted">Update otomatis setiap 10 detik</small>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card stat-card-primary">
                <div class="stat-label">INSTANSI / OPD</div>
                <div class="stat-value stat-text" id="unitKerjaText">
                    {{ $unit_kerja ? strtoupper($unit_kerja) : '-' }}
                </div>
                <div class="stat-note">Unit admin aktif</div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card stat-card-info">
                <div class="stat-label">TOTAL PEGAWAI</div>
                <div class="stat-value" id="totalPegawai">{{ $total_pegawai ?? 0 }}</div>
                <div class="stat-note">Data pegawai unit</div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card stat-card-success">
                <div class="stat-label">USER AKTIF</div>
                <div class="stat-value" id="userAktif">{{ $user_aktif ?? 0 }}</div>
                <div class="stat-note">Pegawai status aktif</div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card stat-card-purple">
                <div class="stat-label">HADIR HARI INI</div>
                <div class="stat-value" id="hadirHariIni">{{ $hadir_hari_ini ?? 0 }}</div>
                <div class="stat-note" id="todayLabel">{{ $today_label ?? date('Y-m-d') }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="panel-card h-100">
                <div class="panel-header">
                    <h5 class="mb-0">Ringkasan Hari Ini</h5>
                    <span class="sync-info">Sinkron: <span id="lastSync">baru saja</span></span>
                </div>

                <div class="summary-grid">
                    <div class="summary-box">
                        <div class="summary-title">HADIR</div>
                        <div class="summary-number text-success" id="summaryHadir">{{ $hadir_hari_ini ?? 0 }}</div>
                    </div>

                    <div class="summary-box">
                        <div class="summary-title">BELUM PRESENSI</div>
                        <div class="summary-number text-danger" id="belumPresensi">{{ $belum_presensi ?? 0 }}</div>
                    </div>

                    <div class="summary-box">
                        <div class="summary-title">TOTAL PEGAWAI</div>
                        <div class="summary-number text-primary" id="summaryTotalPegawai">{{ $total_pegawai ?? 0 }}</div>
                    </div>

                    <div class="summary-box">
                        <div class="summary-title">USER AKTIF</div>
                        <div class="summary-number text-warning" id="summaryUserAktif">{{ $user_aktif ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="panel-card h-100">
                <div class="panel-header">
                    <h5 class="mb-0">Akses Cepat</h5>
                </div>

                <div class="quick-menu">
                    <a href="javascript:void(0)" class="quick-btn">Data Pegawai</a>
                    <a href="javascript:void(0)" class="quick-btn">Presensi Harian</a>
                    <a href="javascript:void(0)" class="quick-btn">Riwayat Presensi</a>
                    <a href="javascript:void(0)" class="quick-btn">Laporan Bulanan</a>
                </div>

                <div class="status-box mt-4">
                    <div class="status-title">Status Dashboard</div>
                    <div class="status-item">
                        <span>Koneksi data</span>
                        <span id="connectionStatus" class="badge bg-success">Normal</span>
                    </div>
                    <div class="status-item">
                        <span>Mode refresh</span>
                        <span class="badge bg-primary">Realtime</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .admin-title {
        font-size: 30px;
        font-weight: 700;
        color: #1f2937;
    }

    .admin-subtitle {
        font-size: 15px;
        color: #6b7280;
    }

    .live-badge {
        display: inline-block;
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: white;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .live-clock {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
    }

    .stat-card {
        border-radius: 18px;
        padding: 22px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        border-left: 6px solid transparent;
        height: 100%;
        transition: all 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-card-primary { border-left-color: #06b6d4; }
    .stat-card-info { border-left-color: #0ea5e9; }
    .stat-card-success { border-left-color: #22c55e; }
    .stat-card-purple { border-left-color: #8b5cf6; }

    .stat-label {
        font-size: 13px;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 14px;
    }

    .stat-value {
        font-size: 42px;
        font-weight: 800;
        color: #1f2937;
        line-height: 1.1;
        margin-bottom: 8px;
    }

    .stat-text {
        font-size: 24px;
        line-height: 1.25;
    }

    .stat-note {
        color: #6b7280;
        font-size: 14px;
    }

    .panel-card {
        background: #fff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .panel-header h5 {
        font-weight: 700;
        color: #1f2937;
    }

    .sync-info {
        color: #6b7280;
        font-size: 13px;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .summary-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 18px;
        border: 1px solid #e5e7eb;
    }

    .summary-title {
        font-size: 13px;
        font-weight: 700;
        color: #6b7280;
        margin-bottom: 10px;
    }

    .summary-number {
        font-size: 34px;
        font-weight: 800;
        line-height: 1;
    }

    .quick-menu {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .quick-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        text-decoration: none;
        background: #f8fafc;
        color: #1f2937;
        padding: 16px 12px;
        border-radius: 14px;
        font-weight: 600;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .quick-btn:hover {
        background: #e0f2fe;
        color: #0369a1;
        text-decoration: none;
    }

    .status-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 18px;
        border: 1px solid #e5e7eb;
    }

    .status-title {
        font-weight: 700;
        margin-bottom: 14px;
        color: #1f2937;
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        color: #374151;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 30px;
        }

        .stat-text {
            font-size: 18px;
        }

        .summary-grid,
        .quick-menu {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    function updateLiveClock() {
        const clock = document.getElementById('liveClock');
        const now = new Date();

        const formatted = now.toLocaleString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        if (clock) {
            clock.textContent = formatted;
        }
    }

    function updateLastSyncLabel() {
        const lastSync = document.getElementById('lastSync');
        const now = new Date();

        const formatted = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        if (lastSync) {
            lastSync.textContent = formatted;
        }
    }

    async function fetchDashboardStats() {
        try {
            const response = await fetch("{{ route('admin.dashboard.stats') }}", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data dashboard');
            }

            const data = await response.json();

            document.getElementById('unitKerjaText').textContent = data.unit_kerja ? data.unit_kerja.toUpperCase() : '-';
            document.getElementById('totalPegawai').textContent = data.total_pegawai ?? 0;
            document.getElementById('userAktif').textContent = data.user_aktif ?? 0;
            document.getElementById('hadirHariIni').textContent = data.hadir_hari_ini ?? 0;
            document.getElementById('todayLabel').textContent = data.today_label ?? '-';

            document.getElementById('summaryHadir').textContent = data.hadir_hari_ini ?? 0;
            document.getElementById('belumPresensi').textContent = data.belum_presensi ?? 0;
            document.getElementById('summaryTotalPegawai').textContent = data.total_pegawai ?? 0;
            document.getElementById('summaryUserAktif').textContent = data.user_aktif ?? 0;

            document.getElementById('connectionStatus').textContent = 'Normal';
            document.getElementById('connectionStatus').className = 'badge bg-success';

            updateLastSyncLabel();
        } catch (error) {
            document.getElementById('connectionStatus').textContent = 'Gangguan';
            document.getElementById('connectionStatus').className = 'badge bg-danger';
            console.error(error);
        }
    }

    updateLiveClock();
    setInterval(updateLiveClock, 1000);

    fetchDashboardStats();
    setInterval(fetchDashboardStats, 10000);
</script>
@endsection