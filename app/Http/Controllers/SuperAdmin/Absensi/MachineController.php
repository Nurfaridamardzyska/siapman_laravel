<?php

namespace App\Http\Controllers\SuperAdmin\Absensi;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\Department;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index(Request $request)
    {
        $unitId = $request->get('unit_id');
        $q = $request->get('q');

        // kalau tabel departments belum siap / opsional, amanin biar tidak error
        $units = class_exists(Department::class) ? Department::orderBy('name')->get() : collect();

        $items = Machine::query()
            ->when($unitId, fn ($qq) => $qq->where('unit_id', $unitId))
            ->when($q, function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('ip_address', 'like', "%{$q}%")
                      ->orWhere('serial_number', 'like', "%{$q}%")
                      ->orWhere('location_name', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('superadmin.absensi.mesin.index', compact('items', 'q', 'unitId', 'units'));
    }
}