<?php

namespace App\Http\Controllers\SuperAdmin\Absensi;

use App\Http\Controllers\Controller;
use App\Models\CompanyLocation;
use App\Models\Location;
use Illuminate\Http\Request;

class CompanyLocationController extends Controller
{
    public function index()
    {
        $items = CompanyLocation::with('location')
            ->orderByDesc('id')
            ->get();

        return view('superadmin.absensi.lokasi-absen-instansi.index', compact('items'));
    }

    public function create()
    {
        $locations = Location::orderBy('name')->get();

        return view('superadmin.absensi.lokasi-absen-instansi.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'location_id' => ['required', 'exists:locations,id'],
            'unit_id' => ['nullable', 'integer', 'min:0'],
            'unit_name' => ['nullable', 'string', 'max:255'],
        ]);

        CompanyLocation::create($data);

        return redirect()
            ->route('superadmin.absensi.lokasi-absen-instansi.index')
            ->with('success', 'Lokasi absen instansi berhasil ditambahkan.');
    }

    public function edit(CompanyLocation $lokasi_absen_instansi)
    {
        $item = $lokasi_absen_instansi;
        $locations = Location::orderBy('name')->get();

        return view('superadmin.absensi.lokasi-absen-instansi.edit', compact('item', 'locations'));
    }

    public function update(Request $request, CompanyLocation $lokasi_absen_instansi)
    {
        $data = $request->validate([
            'location_id' => ['required', 'exists:locations,id'],
            'unit_id' => ['nullable', 'integer'],
            'unit_name' => ['nullable', 'string', 'max:255'],
        ]);

        $lokasi_absen_instansi->update($data);

        return redirect()
            ->route('superadmin.absensi.lokasi-absen-instansi.index')
            ->with('success', 'Lokasi absen instansi berhasil diupdate.');
    }

    public function destroy(CompanyLocation $lokasi_absen_instansi)
    {
        $lokasi_absen_instansi->delete();

        return back()->with('success', 'Lokasi absen instansi berhasil dihapus.');
    }
}