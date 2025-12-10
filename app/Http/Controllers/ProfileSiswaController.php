<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileSiswaController extends Controller
{
    // Tampilkan form biodata
    public function biodata()
    {
        $user = Auth::user();
        $siswa = $user->siswa; // Cek apakah sudah punya data siswa

        return view('profile.biodata', compact('siswa'));
    }

    // Simpan atau update biodata
    public function storeBiodata(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|size:10|unique:siswas,nisn,' . ($user->siswa->id ?? 'NULL'),
            'asal_sekolah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // max 2MB
        ], [
            'nama.required' => 'Nama lengkap harus diisi',
            'nisn.required' => 'NISN harus diisi',
            'nisn.size' => 'NISN harus 10 digit',
            'nisn.unique' => 'NISN sudah terdaftar',
            'asal_sekolah.required' => 'Asal sekolah harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'no_hp.required' => 'Nomor HP harus diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Foto harus format: jpeg, jpg, atau png',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ]);

        // Handle upload foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->siswa && $user->siswa->foto) {
                Storage::disk('public')->delete($user->siswa->foto);
            }

            // Simpan foto baru dengan nama unik
            $file = $request->file('foto');
            $filename = 'foto_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $fotoPath = $file->storeAs('foto_siswa', $filename, 'public');
            
            $validated['foto'] = $fotoPath;
        }

        // Jika sudah punya data siswa, update
        if ($user->siswa) {
            // Jika tidak upload foto baru, hapus key foto dari validated
            if (!$request->hasFile('foto')) {
                unset($validated['foto']);
            }
            
            $user->siswa->update($validated);
            $message = 'Biodata berhasil diperbarui!';
        } else {
            // Jika belum, buat data baru
            Siswa::create([
                'user_id' => $user->id,
                'nama' => $validated['nama'],
                'nisn' => $validated['nisn'],
                'asal_sekolah' => $validated['asal_sekolah'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'foto' => $fotoPath,
            ]);
            $message = 'Biodata berhasil disimpan!';
        }

        return redirect()->route('dashboard')->with('success', $message);
    }
}
