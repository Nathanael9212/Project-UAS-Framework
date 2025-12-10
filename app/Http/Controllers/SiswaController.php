<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::orderBy('nama')->get();
        return view('siswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'nisn'  => 'required|string|max:50|unique:siswas,nisn',
            'asal_sekolah' => 'nullable|string|max:255',
            'alamat'       => 'nullable|string',
            'no_hp'        => 'nullable|string|max:20',
        ]);

        Siswa::create($request->only([
            'nama',
            'nisn',
            'asal_sekolah',
            'alamat',
            'no_hp',
        ]));

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil disimpan.');
    }

    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'nisn'  => 'required|string|max:50|unique:siswas,nisn,' . $siswa->id,
            'asal_sekolah' => 'nullable|string|max:255',
            'alamat'       => 'nullable|string',
            'no_hp'        => 'nullable|string|max:20',
        ]);

        $siswa->update($request->only([
            'nama',
            'nisn',
            'asal_sekolah',
            'alamat',
            'no_hp',
        ]));

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diupdate.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
