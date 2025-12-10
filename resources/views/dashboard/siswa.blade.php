@extends('layouts.mazer')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Siswa')

@section('content')

{{-- Alert jika ada pesan --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show">
        <i class="bi bi-info-circle"></i> {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ✅ HITUNG JUMLAH PENDAFTARAN & SISA KUOTA --}}
@php
    $jumlahPendaftaran = $pendaftarans->count();
    $sisaKuota = 2 - $jumlahPendaftaran;
@endphp

{{-- ⚠️ ALERT JIKA SUDAH DAFTAR 2 JURUSAN --}}
@if($jumlahPendaftaran >= 2)
    <div class="alert alert-warning alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle"></i> 
        <strong>Batas Maksimal Tercapai!</strong> 
        Anda sudah mendaftar <strong>{{ $jumlahPendaftaran }} jurusan</strong>. Maksimal pendaftaran adalah <strong>2 jurusan</strong> saja.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<section class="row">
    {{-- Informasi Biodata Siswa --}}
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    {{-- Foto Profil --}}
                    <div class="me-3">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" 
                                 alt="Foto {{ $siswa->nama }}" 
                                 class="rounded-circle"
                                 style="width: 70px; height: 70px; object-fit: cover; border: 2px solid #435ebe;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama) }}&size=70&background=435ebe&color=fff" 
                                 alt="Foto {{ $siswa->nama }}" 
                                 class="rounded-circle"
                                 style="width: 70px; height: 70px; object-fit: cover; border: 2px solid #435ebe;">
                        @endif
                    </div>
                    
                    <div class="flex-grow-1">
                        <h5 class="mb-0">{{ $siswa->nama }}</h5>
                        <p class="text-muted mb-0">NISN: {{ $siswa->nisn }} | {{ $siswa->asal_sekolah }}</p>
                    </div>
                    <div>
                        <a href="{{ route('profile.biodata') }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Edit Biodata
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Card --}}
    <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon blue mb-2">
                            <i class="bi bi-file-earmark-text-fill"></i>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Total Pendaftaran</h6>
                        <h6 class="font-extrabold mb-0">{{ $totalPendaftaran }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon purple mb-2">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Menunggu</h6>
                        <h6 class="font-extrabold mb-0">{{ $pending }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon green mb-2">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Diterima</h6>
                        <h6 class="font-extrabold mb-0">{{ $diterima }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon red mb-2">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Ditolak</h6>
                        <h6 class="font-extrabold mb-0">{{ $ditolak }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Pendaftaran --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Riwayat Pendaftaran Saya</h5>
                
                {{-- ✅ TOMBOL DAFTAR DENGAN VALIDASI MAKSIMAL 2 JURUSAN --}}
                @if($jumlahPendaftaran >= 2)
                    <button class="btn btn-secondary" disabled title="Anda sudah mendaftar 2 jurusan">
                        <i class="bi bi-lock"></i> Sudah Daftar 2 Jurusan
                    </button>
                @else
                    <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Daftar Jurusan 
                        <span class="badge bg-light text-dark">{{ $sisaKuota }} kuota tersisa</span>
                    </a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jurusan</th>
                                <th>Kode Jurusan</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftarans as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->jurusan->nama_jurusan }}</td>
                                    <td>{{ $p->jurusan->kode_jurusan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($p->status == 'pending')
                                            <span class="badge bg-warning">
                                                <i class="bi bi-clock"></i> Menunggu Konfirmasi
                                            </span>
                                        @elseif($p->status == 'diterima')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Diterima
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle"></i> Ditolak
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                        <p class="text-muted mt-2">Belum ada pendaftaran</p>
                                        
                                        {{-- ✅ TOMBOL EMPTY STATE JUGA DENGAN VALIDASI --}}
                                        @if($jumlahPendaftaran >= 2)
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="bi bi-lock"></i> Batas Maksimal Tercapai
                                            </button>
                                        @else
                                            <a href="{{ route('pendaftaran.create') }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-plus-circle"></i> Daftar Sekarang
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
