<?php

namespace App\Http\Controllers\SuperAdmin\Absensi;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;

class UserDeviceController extends Controller
{
    public function index()
    {
        $items = UserDevice::with('user')
            ->latest()
            ->get();

        return view('superadmin.absensi.perangkat-pengguna.index', compact('items'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();

        return view('superadmin.absensi.perangkat-pengguna.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required','exists:users,id'],
            'device_id' => ['required','string','max:255'],
            'is_active' => ['nullable']
        ]);

        $data['is_active'] = $request->boolean('is_active');

        UserDevice::create($data);

        return redirect()
            ->route('superadmin.absensi.perangkat-pengguna.index')
            ->with('success','Perangkat berhasil ditambahkan');
    }

    public function edit(UserDevice $perangkat_pengguna)
    {
        $users = User::orderBy('name')->get();
        $item = $perangkat_pengguna;

        return view('superadmin.absensi.perangkat-pengguna.edit', compact('item','users'));
    }

    public function update(Request $request, UserDevice $perangkat_pengguna)
    {
        $data = $request->validate([
            'user_id' => ['required','exists:users,id'],
            'device_id' => ['required','string','max:255'],
            'is_active' => ['nullable']
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $perangkat_pengguna->update($data);

        return redirect()
            ->route('superadmin.absensi.perangkat-pengguna.index')
            ->with('success','Perangkat berhasil diupdate');
    }

    public function destroy(UserDevice $perangkat_pengguna)
    {
        $perangkat_pengguna->delete();

        return back()->with('success','Perangkat berhasil dihapus');
    }
}