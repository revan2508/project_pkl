<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard backend
     */
    public function index()
    {
        // Total semua user
        $userCount = User::count();

        // Total guru
        $guruCount = User::where('role', 'Guru')->count();

        // Total siswa
        $siswaCount = User::where('role', 'Siswa')->count();

        return view('backend.dashboard.index', [
            'userCount'  => $userCount,
            'guruCount'  => $guruCount,
            'siswaCount' => $siswaCount,
        ]);
    }
}
