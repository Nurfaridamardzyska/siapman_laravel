<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeFace;
use App\Models\EmployeeWorkLeave;
use App\Models\MachineFault;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\UserLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PegawaiController extends Controller
{
    // ======================
    // CRUD PEGAWAI
    // ======================

    public function index()
    {
        $employees = Employee::with([
            'position',
            'department',
            'employeeType'
        ])->latest()->get();

        return view('superadmin.pegawai.index', compact('employees'));
    }

    public function create()
    {
        return view('superadmin.pegawai.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:50|unique:employees,nip',
            'name' => 'required|string|max:150',
            'status' => 'nullable|string|max:50',
        ]);

        Employee::create([
            'nip' => $validated['nip'],
            'name' => $validated['name'],
            'status' => $validated['status'] ?? 'Aktif',
        ]);

        return redirect()
            ->route('superadmin.pegawai.index')
            ->with('success', 'Data Pegawai berhasil ditambahkan');
    }

    public function show(Employee $pegawai)
    {
        return view('superadmin.pegawai.show', compact('pegawai'));
    }

    public function edit(Employee $pegawai)
    {
        return view('superadmin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Employee $pegawai)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:50|unique:employees,nip,' . $pegawai->id,
            'name' => 'required|string|max:150',
            'status' => 'nullable|string|max:50',
        ]);

        $pegawai->update([
            'nip' => $validated['nip'],
            'name' => $validated['name'],
            'status' => $validated['status'] ?? 'Aktif',
        ]);

        return redirect()
            ->route('superadmin.pegawai.index')
            ->with('success', 'Data Pegawai berhasil diupdate');
    }

    public function destroy(Employee $pegawai)
    {
        $pegawai->delete();

        return redirect()
            ->route('superadmin.pegawai.index')
            ->with('success', 'Data Pegawai berhasil dihapus');
    }

    // ======================
    // MANAJEMEN WAJAH
    // ======================

    public function wajah(Request $request)
    {
        $query = Employee::with('faces');

        if ($request->status === 'registered') {
            $query->has('faces');
        }

        if ($request->status === 'not_registered') {
            $query->doesntHave('faces');
        }

        $employees = $query->latest()->get();

        return view('superadmin.pegawai.wajah', compact('employees'));
    }

    public function storeWajah(Request $request, Employee $pegawai)
    {
        $validated = $request->validate([
            'face_image' => 'required|image|max:2048',
        ]);

        $path = $validated['face_image']->store('faces', 'public');

        EmployeeFace::create([
            'employee_id' => $pegawai->id,
            'image_path' => $path,
            'is_active' => true,
        ]);

        return back()->with('success', 'Wajah berhasil ditambahkan');
    }

    public function deleteWajah(EmployeeFace $face)
    {
        if ($face->image_path) {
            Storage::disk('public')->delete($face->image_path);
        }

        $face->delete();

        return back()->with('success', 'Wajah berhasil dihapus');
    }

    public function setAktif(EmployeeFace $face)
    {
        EmployeeFace::where('employee_id', $face->employee_id)
            ->update(['is_active' => false]);

        $face->update(['is_active' => true]);

        return back()->with('success', 'Wajah berhasil diaktifkan');
    }

    // ======================
    // DOKUMEN KETIDAKHADIRAN
    // ======================

    public function ketidakhadiran()
    {
        $leaves = EmployeeWorkLeave::with('employee')->latest()->get();
        $faults = MachineFault::with('employee')->latest()->get();

        return view('superadmin.pegawai.ketidakhadiran', compact('leaves', 'faults'));
    }

    public function updateLeaveStatus(Request $request, EmployeeWorkLeave $leave)
    {
        $validated = $request->validate([
            'status' => 'nullable|string|max:50',
        ]);

        $leave->update([
            'status' => $validated['status'] ?? 'Disetujui',
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Status cuti berhasil diperbarui');
    }

    public function updateFaultStatus(Request $request, MachineFault $fault)
    {
        $validated = $request->validate([
            'status' => 'nullable|string|max:50',
        ]);

        $fault->update([
            'status' => $validated['status'] ?? 'Disetujui',
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Status kendala berhasil diperbarui');
    }

    // ======================
    // DATA PENGGUNA
    // ======================

    public function pengguna(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('opd')) {
            $query->where('unit_kerja', 'like', '%' . $request->opd . '%');
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('superadmin.pengguna.index', compact('users'));
    }

    public function createPengguna()
    {
        return view('superadmin.pengguna.create');
    }

    public function storePengguna(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100|unique:users,username',
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|max:50',
            'nip' => 'nullable|string|max:50',
            'unit_kerja' => 'nullable|string|max:150',
            'status' => 'nullable|in:Aktif,Nonaktif',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nip' => $validated['nip'] ?? null,
            'role' => $validated['role'],
            'unit_kerja' => $validated['unit_kerja'] ?? null,
            'status' => $validated['status'] ?? 'Aktif',
        ]);

        if (class_exists(UserLog::class)) {
            UserLog::create([
                'user_id' => $user->id,
                'action' => 'create_user',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'success',
                'description' => 'Akun pengguna baru dibuat oleh superadmin.',
            ]);
        }

        return redirect()
            ->route('superadmin.pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function editPengguna(User $user)
    {
        return view('superadmin.pengguna.edit', compact('user'));
    }

    public function updatePengguna(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'role' => 'required|string|max:50',
            'nip' => 'nullable|string|max:50',
            'unit_kerja' => 'nullable|string|max:150',
            'status' => 'nullable|in:Aktif,Nonaktif',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'nip' => $validated['nip'] ?? null,
            'unit_kerja' => $validated['unit_kerja'] ?? null,
            'status' => $validated['status'] ?? $user->status,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        if (class_exists(UserLog::class)) {
            UserLog::create([
                'user_id' => $user->id,
                'action' => 'update_user',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'success',
                'description' => 'Data pengguna diperbarui oleh superadmin.',
            ]);
        }

        return redirect()
            ->route('superadmin.pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function resetPassword(Request $request, User $user)
    {
        $newPassword = 'password123';

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        if (class_exists(UserLog::class)) {
            UserLog::create([
                'user_id' => $user->id,
                'action' => 'reset_password',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'success',
                'description' => 'Password pengguna direset oleh superadmin.',
            ]);
        }

        return back()->with('success', 'Password direset ke password123');
    }

    public function toggleStatus(Request $request, User $user)
    {
        $newStatus = $user->status === 'Aktif' ? 'Nonaktif' : 'Aktif';

        $user->update([
            'status' => $newStatus,
        ]);

        if (class_exists(UserLog::class)) {
            UserLog::create([
                'user_id' => $user->id,
                'action' => 'toggle_status',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'success',
                'description' => 'Status pengguna diubah menjadi ' . $newStatus . '.',
            ]);
        }

        return back()->with('success', 'Status pengguna diperbarui');
    }

    public function bulkStatus(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        User::whereIn('id', $validated['user_ids'])->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('superadmin.pengguna.index')
            ->with('success', 'Status pengguna berhasil diperbarui secara massal');
    }

    public function destroyPengguna(User $user)
    {
        if ($user->role === 'superadmin') {
            return back()->with('error', 'Superadmin tidak bisa dihapus');
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus');
    }

    public function riwayatLogin(User $user)
    {
        $logs = class_exists(UserLog::class)
            ? UserLog::where('user_id', $user->id)->latest()->paginate(20)
            : collect();

        return view('superadmin.pengguna.riwayat-login', compact('user', 'logs'));
    }

    public function perangkat(User $user)
    {
        $devices = class_exists(UserDevice::class)
            ? UserDevice::where('user_id', $user->id)->latest()->get()
            : collect();

        return view('superadmin.pengguna.perangkat', compact('user', 'devices'));
    }

    public function lokasiAbsen(User $user)
    {
        return view('superadmin.pengguna.lokasi-absen', compact('user'));
    }

    public function detailAkses(User $user)
    {
        return view('superadmin.pengguna.detail-akses', compact('user'));
    }

    public function exportPengguna(): StreamedResponse
    {
        $fileName = 'data_pengguna.csv';
        $users = User::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () use ($users) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID',
                'Username',
                'Nama Lengkap',
                'Email',
                'NIP',
                'Role',
                'Unit Kerja',
                'Status',
            ]);

            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->username,
                    $user->name,
                    $user->email,
                    $user->nip,
                    $user->role,
                    $user->unit_kerja,
                    $user->status,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importPengguna(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');

        if ($handle === false) {
            return back()->with('error', 'File tidak dapat dibaca.');
        }

        $header = fgetcsv($handle);

        if (!$header) {
            fclose($handle);
            return back()->with('error', 'File kosong atau format tidak valid.');
        }

        $header = array_map(fn($h) => strtolower(trim($h)), $header);

        $imported = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) !== count($header)) {
                $skipped++;
                continue;
            }

            $data = array_combine($header, $row);

            if (empty($data['username']) || empty($data['name']) || empty($data['email']) || empty($data['role'])) {
                $skipped++;
                continue;
            }

            $exists = User::where('username', $data['username'])
                ->orWhere('email', $data['email'])
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            User::create([
                'username' => trim($data['username']),
                'name' => trim($data['name']),
                'email' => trim($data['email']),
                'password' => Hash::make($data['password'] ?? 'password123'),
                'nip' => $data['nip'] ?? null,
                'role' => trim($data['role']),
                'unit_kerja' => $data['unit_kerja'] ?? null,
                'status' => $data['status'] ?? 'Aktif',
            ]);

            $imported++;
        }

        fclose($handle);

        return back()->with('success', "Import selesai. Berhasil: {$imported}, Dilewati: {$skipped}");
    }
}