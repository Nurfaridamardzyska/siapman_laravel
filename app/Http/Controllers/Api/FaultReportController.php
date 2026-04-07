<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\FaultReport;
use Illuminate\Http\Request;

class FaultReportController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->nip) {
            return response()->json([
                'message' => 'User ini belum memiliki NIP',
                'data' => [],
            ], 422);
        }

        $employee = Employee::where('nip', $user->nip)->first();

        if (!$employee) {
            return response()->json([
                'message' => 'Data pegawai tidak ditemukan berdasarkan NIP user',
                'data' => [],
            ], 404);
        }

        $reports = FaultReport::where('employee_id', $employee->id)
            ->orderByDesc('report_date')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'message' => 'Laporan kendala berhasil diambil',
            'data' => $reports->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'status' => $item->status,
                    'handled_by' => $item->handled_by,
                    'report_date' => optional($item->report_date)->format('Y-m-d'),
                    'evidence_path' => $item->evidence_path,
                    'evidence_url' => $item->evidence_path ? asset('storage/' . $item->evidence_path) : null,
                    'created_at' => optional($item->created_at)->format('Y-m-d H:i:s'),
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->nip) {
            return response()->json([
                'message' => 'User ini belum memiliki NIP',
            ], 422);
        }

        $employee = Employee::where('nip', $user->nip)->first();

        if (!$employee) {
            return response()->json([
                'message' => 'Data pegawai tidak ditemukan berdasarkan NIP user',
            ], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'report_date' => 'required|date',
        ]);

        $report = FaultReport::create([
            'employee_id' => $employee->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
            'handled_by' => 'KOMINFO',
            'report_date' => $request->report_date,
        ]);

        return response()->json([
            'message' => 'Laporan kendala berhasil dikirim',
            'data' => $report,
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();

        $employee = Employee::where('nip', $user->nip)->first();

        if (!$employee) {
            return response()->json([
                'message' => 'Data pegawai tidak ditemukan',
            ], 404);
        }

        $report = FaultReport::where('employee_id', $employee->id)
            ->where('id', $id)
            ->first();

        if (!$report) {
            return response()->json([
                'message' => 'Laporan kendala tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail laporan kendala berhasil diambil',
            'data' => $report,
        ]);
    }
}