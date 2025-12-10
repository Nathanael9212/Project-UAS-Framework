@extends('layouts.mazer')

@section('title', 'Daftar Jurusan')
@section('page-title', 'Daftar Jurusan Baru')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Form Pendaftaran Jurusan</h5>
        </div>
        <div class="card-body">
            {{-- Notifikasi Error --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle"></i> <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Notifikasi Success --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Cek jumlah pendaftaran --}}
            @php
                $jumlahPendaftaran = Auth::user()->siswa->pendaftarans->count();
            @endphp

            {{-- Alert: Sudah Daftar 2 Jurusan --}}
            @if($jumlahPendaftaran >= 2)
                <div class="alert alert-warning">
                    <i class="bi bi-info-circle"></i> 
                    <strong>Batas Maksimal Tercapai!</strong> 
                    <p class="mb-0">Anda sudah mendaftar <strong>{{ $jumlahPendaftaran }} jurusan</strong>. Maksimal pendaftaran adalah <strong>2 jurusan</strong> saja.</p>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('pendaftaran.my') }}" class="btn btn-primary">
                        <i class="bi bi-eye"></i> Lihat Status Pendaftaran
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-house"></i> Kembali ke Dashboard
                    </a>
                </div>

            @else
                {{-- Info: Sisa Kuota --}}
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    Anda sudah mendaftar <strong>{{ $jumlahPendaftaran }} jurusan</strong>. 
                    Sisa kuota: <strong>{{ 2 - $jumlahPendaftaran }} jurusan</strong> lagi.
                </div>

                {{-- Form Pendaftaran --}}
                <form action="{{ route('pendaftaran.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="jurusan_id" class="form-label">
                            Pilih Jurusan <span class="text-danger">*</span>
                        </label>
                        <select name="jurusan_id" 
                                id="jurusan_id" 
                                class="form-select @error('jurusan_id') is-invalid @enderror" 
                                required>
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach($jurusans as $jurusan)
                                {{-- Cek apakah jurusan sudah pernah didaftar --}}
                                @php
                                    $sudahDaftar = Auth::user()->siswa->pendaftarans->contains('jurusan_id', $jurusan->id);
                                @endphp

                                <option value="{{ $jurusan->id }}" 
                                        {{ $sudahDaftar ? 'disabled' : '' }}
                                        {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama_jurusan }} ({{ $jurusan->kode_jurusan }})
                                    {{ $sudahDaftar ? '✓ Sudah Didaftar' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('jurusan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> 
                            Jurusan yang sudah Anda daftarkan tidak dapat dipilih lagi.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Informasi Pendaftar</label>
                        <div class="card bg-light">
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td width="150"><strong>Nama Lengkap</strong></td>
                                        <td>: {{ Auth::user()->siswa->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>NISN</strong></td>
                                        <td>: {{ Auth::user()->siswa->nisn }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Asal Sekolah</strong></td>
                                        <td>: {{ Auth::user()->siswa->asal_sekolah }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>: {{ Auth::user()->email }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Daftar Sekarang
                        </button>
                        <a href="{{ route('pendaftaran.my') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</section>
@endsection
