<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    
public function index()
{
    $kelasSaya = [];

    if (Auth::check() && Auth::user()->role === 'siswa') {
        $kelasSaya = Auth::user()
            ->kelas()
            ->withPivot('created_at')
            ->get();
    }

    return view('index', compact('kelasSaya'));
}
}