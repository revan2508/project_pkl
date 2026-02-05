<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MapelController extends Controller
{
    public function index()
    {
        // WAJIB with('kelas')
        $mapel = Mapel::with('kelas')->latest()->get();
        return view('guru.mapel.index', compact('mapel'));
    }

    public function create()
    {
        return view('guru.mapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => [
                'required',
                'string',
                'max:100',
                Rule::unique('mapel', 'nama_mapel'),
            ],
        ]);

        Mapel::create([
            'nama_mapel' => $request->nama_mapel,
        ]);

        return redirect()
            ->route('guru.mapel.index')
            ->with('success', 'Mapel berhasil ditambahkan');
    }

    public function edit(Mapel $mapel)
    {
        return view('guru.mapel.edit', compact('mapel'));
    }

    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'nama_mapel' => [
                'required',
                'string',
                'max:100',
                Rule::unique('mapel', 'nama_mapel')->ignore($mapel->id),
            ],
        ]);

        $mapel->update([
            'nama_mapel' => $request->nama_mapel,
        ]);

        return redirect()
            ->route('guru.mapel.index')
            ->with('success', 'Mapel berhasil diupdate');
    }

    public function destroy(Mapel $mapel)
    {
        // HAPUS RELASI PIVOT DULU
        $mapel->kelas()->detach();
        $mapel->delete();

        return redirect()
            ->route('guru.mapel.index')
            ->with('success', 'Mapel berhasil dihapus');
    }
}
