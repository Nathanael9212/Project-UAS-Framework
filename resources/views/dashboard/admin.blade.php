@extends('layouts.mazer')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<section class="row">
    {{-- Card 1: Total Siswa --}}
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon purple mb-2">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Total Siswa</h6>
                        <h6 class="font-extrabold mb-0">{{ $totalSiswa }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: Total Pendaftaran --}}
    <div class="col-6 col-lg-3 col-md-6">
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

    {{-- Card 3: Pending --}}
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon orange mb-2">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Pending</h6>
                        <h6 class="font-extrabold mb-0">{{ $pending }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 4: Diterima --}}
    <div class="col-6 col-lg-3 col-md-6">
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

    {{-- Row Baru untuk Card Ditolak --}}
    <div class="col-6 col-lg-3 col-md-6">
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
</section>
@endsection
