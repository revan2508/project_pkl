<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        return view('guru.index', [
            'totalKelas'   => auth()->user()->kelasGuru()->count() ?? 0,
            'totalMapel'   => \App\Models\Mapel::count(),
            'totalTugas'   => \App\Models\Tugas::count(),
            'belumDinilai' => \App\Models\PengumpulanTugas::whereNull('nilai')->count(),
        ]);
    }
}