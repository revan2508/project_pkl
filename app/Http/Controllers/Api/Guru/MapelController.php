<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MapelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // GET /api/guru/mapel
    public function index()
    {
        $mapel = Mapel::with('kelas')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $mapel
        ]);
    }

    // POST /api/guru/mapel
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

        $mapel = Mapel::create([
            'nama_mapel' => $request->nama_mapel,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil ditambahkan',
            'data' => $mapel
        ], 201);
    }

    // GET /api/guru/mapel/{id}
    public function show($id)
    {
        $mapel = Mapel::with('kelas')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $mapel
        ]);
    }

    // PUT /api/guru/mapel/{id}
    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);

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

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil diupdate',
            'data' => $mapel
        ]);
    }

    // DELETE /api/guru/mapel/{id}
    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);

        // hapus relasi dulu
        $mapel->kelas()->detach();

        $mapel->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil dihapus'
        ]);
    }
}
