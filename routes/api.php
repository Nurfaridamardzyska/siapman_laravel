<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FaceAttendanceController;
use App\Http\Controllers\Api\AbsenceDocumentController;
use App\Http\Controllers\Api\FaultReportController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::post('/register-face', [FaceAttendanceController::class, 'registerFace']);
    Route::post('/attendance-face', [FaceAttendanceController::class, 'verify']);
    Route::get('/attendance-history', [FaceAttendanceController::class, 'history']);
    Route::get('/today-attendance', [FaceAttendanceController::class, 'todayAttendance']);

    Route::get('/absence-documents', [AbsenceDocumentController::class, 'index']);
    Route::post('/absence-documents', [AbsenceDocumentController::class, 'store']);
    Route::get('/absence-documents/{id}', [AbsenceDocumentController::class, 'show']);

    Route::get('/fault-reports', [FaultReportController::class, 'index']);
    Route::post('/fault-reports', [FaultReportController::class, 'store']);
    Route::get('/fault-reports/{id}', [FaultReportController::class, 'show']);
});