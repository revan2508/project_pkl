<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;

class KelasMapelController extends Controller
{
    public function create(Kelas $kelas)
    {
        $mapel = Mapel::orderBy('nama_mapel')->get();

        return view('guru.kelas.mapel', compact('kelas', 'mapel'));
    }

    public function store(Request $request, Kelas $kelas)
    {
        $request->validate([
            'mapel_id' => 'required|exists:mapel,id'
        ]);

        $kelas->mapel()->syncWithoutDetaching($request->mapel_id);

        return redirect()
            ->route('guru.kelas.index')
            ->with('success', 'Mapel berhasil ditambahkan ke kelas');
    }
}
