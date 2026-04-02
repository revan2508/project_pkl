<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function show()
    {
        $user  = Auth::user();
        $siswa = $user->siswa()->firstOrCreate(
            ['user_id' => $user->id],
            ['nis' => '', 'kelas' => '', 'alamat' => '', 'foto' => '']
        );

        return response()->json([
            'success' => true,
            'data' => [
                'id'     => $user->id,
                'name'   => $user->name,
                'email'  => $user->email,
                'role'   => $user->role,
                'profil' => $siswa,
            ]
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'   => 'nullable|string|max:100',
            'nis'    => 'nullable|string|max:20',
            'kelas'  => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'foto'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'foto.image' => 'File harus berupa gambar',
            'foto.max'   => 'Ukuran foto maksimal 2MB',
        ]);

        $user  = Auth::user();
        $siswa = $user->siswa()->firstOrCreate(
            ['user_id' => $user->id],
            ['nis' => '', 'kelas' => '', 'alamat' => '', 'foto' => '']
        );

        if ($request->filled('name')) {
            $user->update(['name' => $request->name]);
        }

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_siswa', 'public');
            $siswa->foto = $path;
        }

        $siswa->nis    = $request->nis    ?? $siswa->nis;
        $siswa->kelas  = $request->kelas  ?? $siswa->kelas;
        $siswa->alamat = $request->alamat ?? $siswa->alamat;
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => [
                'id'     => $user->id,
                'name'   => $user->name,
                'email'  => $user->email,
                'profil' => $siswa->fresh(),
            ]
        ]);
    }
}