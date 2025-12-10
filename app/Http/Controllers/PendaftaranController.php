<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    // ============ UNTUK ADMIN/PETUGAS ============

    // Lihat semua pendaftaran (Admin)
    public function index()
    {
        $pendaftarans = Pendaftaran::with(['siswa', 'jurusan'])
            ->latest()
            ->get();

        return view('pendaftaran.index', compact('pendaftarans'));
    }

    // Form tambah pendaftaran (Admin bisa pilih siswa mana saja)
    public function create()
    {
        $siswas = Siswa::orderBy('nama')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();

        return view('pendaftaran.create', compact('siswas', 'jurusans'));
    }

    // Simpan pendaftaran (Admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|in:pending,diterima,ditolak',
        ], [
            'siswa_id.required' => 'Pilih siswa terlebih dahulu',
            'jurusan_id.required' => 'Pilih jurusan terlebih dahulu',
            'tanggal_daftar.required' => 'Tanggal pendaftaran harus diisi',
            'status.required' => 'Status pendaftaran harus dipilih',
        ]);

        Pendaftaran::create($validated);

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Data pendaftaran berhasil ditambahkan');
    }

    // Form edit pendaftaran (Admin bisa ubah status)
    public function edit($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $siswas = Siswa::orderBy('nama')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();

        return view('pendaftaran.edit', compact('pendaftaran', 'siswas', 'jurusans'));
    }

    // Update pendaftaran (Admin)
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|in:pending,diterima,ditolak',
        ], [
            'siswa_id.required' => 'Pilih siswa terlebih dahulu',
            'jurusan_id.required' => 'Pilih jurusan terlebih dahulu',
            'tanggal_daftar.required' => 'Tanggal pendaftaran harus diisi',
            'status.required' => 'Status pendaftaran harus dipilih',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update($validated);

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Data pendaftaran berhasil diperbarui');
    }

    // Hapus pendaftaran (Admin)
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Data pendaftaran berhasil dihapus');
    }

    // ============ UNTUK SISWA ============

    // Lihat pendaftaran milik siswa yang login
    public function myPendaftaran()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) {
            return redirect()->route('profile.biodata')
                ->with('info', 'Silakan lengkapi biodata Anda terlebih dahulu.');
        }

        $pendaftarans = Pendaftaran::where('siswa_id', $siswa->id)
            ->with('jurusan')
            ->latest()
            ->get();

        return view('pendaftaran.my', compact('pendaftarans', 'siswa'));
    }

    // Lihat daftar semua pendaftar (Siswa bisa lihat siswa lain yang daftar)
    public function listPendaftar()
    {
        // Ambil semua pendaftaran dengan status pending atau diterima
        // Tidak tampilkan yang ditolak untuk menjaga privasi
        $pendaftarans = Pendaftaran::with(['siswa', 'jurusan'])
            ->whereIn('status', ['pending', 'diterima'])
            ->latest()
            ->get();

        return view('pendaftaran.list-pendaftar', compact('pendaftarans'));
    }

    // Form daftar jurusan (Siswa hanya bisa daftar untuk dirinya sendiri)
    public function createForSiswa()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) {
            return redirect()->route('profile.biodata')
                ->with('error', 'Silakan lengkapi biodata Anda terlebih dahulu sebelum mendaftar jurusan.');
        }

        $jurusans = Jurusan::orderBy('nama_jurusan')->get();

        return view('pendaftaran.create-siswa', compact('jurusans', 'siswa'));
    }

    // Simpan pendaftaran siswa (Siswa hanya bisa daftar untuk dirinya sendiri)
    public function storeForSiswa(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        // Cek apakah sudah isi biodata
        if (!$siswa) {
            return redirect()->route('profile.biodata')
                ->with('error', 'Anda harus melengkapi biodata terlebih dahulu sebelum mendaftar jurusan.');
        }

        // ✅ VALIDASI BARU: CEK MAKSIMAL 2 JURUSAN
        $jumlahPendaftaran = Pendaftaran::where('siswa_id', $siswa->id)->count();

        if ($jumlahPendaftaran >= 2) {
            return redirect()->back()->with('error', 'Anda sudah mendaftar 2 jurusan. Maksimal pendaftaran adalah 2 jurusan saja.');
        }

        // Validasi input
        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        // ✅ CEK APAKAH SUDAH PERNAH DAFTAR JURUSAN INI
        $sudahDaftar = Pendaftaran::where('siswa_id', $siswa->id)
            ->where('jurusan_id', $request->jurusan_id)
            ->exists();

        if ($sudahDaftar) {
            return redirect()->back()->with('error', 'Anda sudah mendaftar jurusan ini sebelumnya.');
        }

        // Simpan pendaftaran
        Pendaftaran::create([
            'siswa_id'      => $siswa->id,
            'jurusan_id'    => $request->jurusan_id,
            'tanggal_daftar' => now(),
            'status'        => 'pending',
        ]);

        return redirect()->route('pendaftaran.my')
            ->with('success', 'Pendaftaran jurusan berhasil! Silakan tunggu konfirmasi dari admin.');
    }
}
