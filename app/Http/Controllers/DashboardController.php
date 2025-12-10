<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin' || $user->role == 'petugas') {
            // Dashboard Admin: tampilkan semua data
            $totalSiswa       = Siswa::count();
            $totalPendaftaran = Pendaftaran::count();
            $pending          = Pendaftaran::where('status', 'pending')->count();
            $diterima         = Pendaftaran::where('status', 'diterima')->count();
            $ditolak          = Pendaftaran::where('status', 'ditolak')->count();

            return view('dashboard.admin', compact(
                'totalSiswa',
                'totalPendaftaran',
                'pending',
                'diterima',
                'ditolak'
            ));
        } else {
            // Dashboard Siswa
            $siswa = $user->siswa;
            
            // Jika belum isi biodata, redirect ke form biodata
            if (!$siswa) {
                return redirect()->route('profile.biodata')
                    ->with('info', 'Selamat datang! Silakan lengkapi biodata Anda terlebih dahulu.');
            }

            // Ambil data pendaftaran siswa
            $pendaftarans = Pendaftaran::where('siswa_id', $siswa->id)
                ->with('jurusan')
                ->latest()
                ->get();

            // Hitung statistik
            $totalPendaftaran = $pendaftarans->count();
            $pending = $pendaftarans->where('status', 'pending')->count();
            $diterima = $pendaftarans->where('status', 'diterima')->count();
            $ditolak = $pendaftarans->where('status', 'ditolak')->count();

            return view('dashboard.siswa', compact(
                'pendaftarans',
                'siswa',
                'totalPendaftaran',
                'pending',
                'diterima',
                'ditolak'
            ));
        }
    }
}
