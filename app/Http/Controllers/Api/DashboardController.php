<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'Dashboard berhasil diambil',
            'user' => $request->user(),
            'total_pegawai' => Employee::count(),
            'total_user' => User::count(),
        ]);
    }
}