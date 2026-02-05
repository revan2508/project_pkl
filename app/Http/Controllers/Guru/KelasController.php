<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::withCount('mapel')
            ->where('guru_id', Auth::id())
            ->latest()
            ->get();

        return view('guru.kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('guru.kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kelas', 'nama_kelas')
                    ->where('guru_id', Auth::id()),
            ],
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'kode_kelas' => strtoupper(Str::random(6)),
            'guru_id'    => Auth::id(),
        ]);

        return redirect()
            ->route('guru.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit(Kelas $kelas)
    {
        return view('guru.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kelas', 'nama_kelas')
                    ->where('guru_id', Auth::id())
                    ->ignore($kelas->id),
            ],
        ]);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()
            ->route('guru.kelas.index')
            ->with('success', 'Kelas berhasil diupdate');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->mapel()->detach();
        $kelas->delete();

        return redirect()
            ->route('guru.kelas.index')
            ->with('success', 'Kelas berhasil dihapus');
    }
}
