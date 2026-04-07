<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\AttendanceLogStatus;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FaceAttendanceController extends Controller
{
    public function registerFace(Request $request)
    {
        $request->validate([
            'face_image' => 'required|image',
        ]);

        $user = $request->user();

        if (!$user->nip) {
            return response()->json([
                'message' => 'User ini belum memiliki NIP',
            ], 422);
        }

        $employee = Employee::where('nip', $user->nip)->first();

        if (!$employee) {
            return response()->json([
                'message' => 'Data pegawai dengan NIP tersebut tidak ditemukan',
            ], 404);
        }

        $response = Http::attach(
            'face_image',
            file_get_contents($request->file('face_image')->getRealPath()),
            $request->file('face_image')->getClientOriginalName()
        )->post('http://127.0.0.1:5001/register', [
            'user_id' => $user->id,
        ]);

        return response()->json($response->json(), $response->status());
    }

    public function verify(Request $request)
    {
        try {
            $request->validate([
                'face_image' => 'required|image',
                'type' => 'required|in:masuk,pulang',
            ]);

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

            $response = Http::attach(
                'face_image',
                file_get_contents($request->file('face_image')->getRealPath()),
                $request->file('face_image')->getClientOriginalName()
            )->post('http://127.0.0.1:5001/verify', [
                'user_id' => $user->id,
            ]);

            $result = $response->json();

            if (!$response->successful()) {
                return response()->json($result, $response->status());
            }

            if (!($result['matched'] ?? false)) {
                return response()->json([
                    'message' => 'Wajah tidak dikenali',
                    'matched' => false,
                    'confidence' => $result['confidence'] ?? null,
                    'distance' => $result['distance'] ?? null,
                ], 422);
            }

            $today = now()->toDateString();

            $status = AttendanceLogStatus::where('code', 'ONTIME')->first();

            if (!$status) {
                return response()->json([
                    'message' => 'Status absensi ONTIME tidak ditemukan',
                ], 500);
            }

            $attendanceLog = AttendanceLog::firstOrCreate(
                [
                    'employee_id' => $employee->id,
                    'attendance_date' => $today,
                ],
                [
                    'status_id' => $status->id,
                    'note' => 'Absensi via face recognition',
                ]
            );

            if ($request->type === 'masuk') {
                if ($attendanceLog->check_in_at) {
                    return response()->json([
                        'message' => 'Anda sudah melakukan absensi masuk hari ini',
                        'matched' => true,
                        'confidence' => $result['confidence'] ?? null,
                        'distance' => $result['distance'] ?? null,
                        'type' => 'masuk',
                        'attendance_date' => optional($attendanceLog->attendance_date)->format('Y-m-d'),
                        'check_in_at' => $attendanceLog->check_in_at,
                        'check_out_at' => $attendanceLog->check_out_at,
                    ], 200);
                }

                $attendanceLog->check_in_at = now()->format('H:i:s');
                $attendanceLog->check_in_photo_path = $request->file('face_image')
                    ->store('attendance_faces/checkin', 'public');
            }

            if ($request->type === 'pulang') {
                if (!$attendanceLog->check_in_at) {
                    return response()->json([
                        'message' => 'Anda belum melakukan absensi masuk hari ini',
                    ], 422);
                }

                if ($attendanceLog->check_out_at) {
                    return response()->json([
                        'message' => 'Anda sudah melakukan absensi pulang hari ini',
                        'matched' => true,
                        'confidence' => $result['confidence'] ?? null,
                        'distance' => $result['distance'] ?? null,
                        'type' => 'pulang',
                        'attendance_date' => optional($attendanceLog->attendance_date)->format('Y-m-d'),
                        'check_in_at' => $attendanceLog->check_in_at,
                        'check_out_at' => $attendanceLog->check_out_at,
                    ], 200);
                }

                $attendanceLog->check_out_at = now()->format('H:i:s');
                $attendanceLog->check_out_photo_path = $request->file('face_image')
                    ->store('attendance_faces/checkout', 'public');
            }

            $attendanceLog->save();

            return response()->json([
                'message' => 'Absensi berhasil',
                'matched' => true,
                'confidence' => $result['confidence'] ?? null,
                'distance' => $result['distance'] ?? null,
                'type' => $request->type,
                'attendance_date' => optional($attendanceLog->attendance_date)->format('Y-m-d'),
                'check_in_at' => $attendanceLog->check_in_at,
                'check_out_at' => $attendanceLog->check_out_at,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }

    public function history(Request $request)
    {
        try {
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

            $logs = AttendanceLog::with('status')
                ->where('employee_id', $employee->id)
                ->orderByDesc('attendance_date')
                ->orderByDesc('check_in_at')
                ->get();

            return response()->json([
                'message' => 'Riwayat absensi berhasil diambil',
                'data' => $logs->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'employee_id' => $item->employee_id,
                        'attendance_date' => optional($item->attendance_date)->format('Y-m-d'),
                        'check_in_at' => $item->check_in_at,
                        'check_out_at' => $item->check_out_at,
                        'status_id' => $item->status_id,
                        'status' => $item->status ? [
                            'id' => $item->status->id,
                            'code' => $item->status->code,
                            'name' => $item->status->name,
                        ] : null,
                        'check_in_photo_path' => $item->check_in_photo_path,
                        'check_out_photo_path' => $item->check_out_photo_path,
                        'note' => $item->note,
                    ];
                }),
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }

    public function todayAttendance(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user->nip) {
                return response()->json([
                    'message' => 'User ini belum memiliki NIP',
                    'data' => null,
                ], 422);
            }

            $employee = Employee::where('nip', $user->nip)->first();

            if (!$employee) {
                return response()->json([
                    'message' => 'Data pegawai tidak ditemukan berdasarkan NIP user',
                    'data' => null,
                ], 404);
            }

            $today = now()->toDateString();

            $log = AttendanceLog::with('status')
                ->where('employee_id', $employee->id)
                ->whereDate('attendance_date', $today)
                ->first();

            return response()->json([
                'message' => 'Status absensi hari ini berhasil diambil',
                'data' => $log ? [
                    'id' => $log->id,
                    'employee_id' => $log->employee_id,
                    'attendance_date' => optional($log->attendance_date)->format('Y-m-d'),
                    'check_in_at' => $log->check_in_at,
                    'check_out_at' => $log->check_out_at,
                    'status_id' => $log->status_id,
                    'status' => $log->status ? [
                        'id' => $log->status->id,
                        'code' => $log->status->code,
                        'name' => $log->status->name,
                    ] : null,
                    'check_in_photo_path' => $log->check_in_photo_path,
                    'check_out_photo_path' => $log->check_out_photo_path,
                    'note' => $log->note,
                ] : null,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }
}