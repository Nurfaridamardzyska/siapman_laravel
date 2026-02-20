<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        return view('superadmin.pegawai.index');
    }

    public function wajah()
    {
        return view('superadmin.pegawai.wajah');
    }

    public function dokumen()
    {
        return view('superadmin.pegawai.dokumen');
    }
}