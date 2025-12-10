@extends('layouts.mazer')

@section('title', 'Edit Pendaftaran')
@section('page-title', 'Edit Pendaftaran')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Form Edit Pendaftaran</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Terdapat kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('pendaftaran.update', $pendaftaran->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="siswa_id" class="form-label">Pilih Siswa <span class="text-danger">*</span></label>
                    <select class="form-select @error('siswa_id') is-invalid @enderror" 
                            id="siswa_id" name="siswa_id" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach ($siswas as $siswa)
                            <option value="{{ $siswa->id }}" 
                                {{ (old('siswa_id', $pendaftaran->siswa_id) == $siswa->id) ? 'selected' : '' }}>
                                {{ $siswa->nama }} - NISN: {{ $siswa->nisn }}
                            </option>
                        @endforeach
                    </select>
                    @error('siswa_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jurusan_id" class="form-label">Pilih Jurusan <span class="text-danger">*</span></label>
                    <select class="form-select @error('jurusan_id') is-invalid @enderror" 
                            id="jurusan_id" name="jurusan_id" required>
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach ($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" 
                                {{ (old('jurusan_id', $pendaftaran->jurusan_id) == $jurusan->id) ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan }} ({{ $jurusan->kode_jurusan }})
                            </option>
                        @endforeach
                    </select>
                    @error('jurusan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_daftar" class="form-label">Tanggal Pendaftaran <span class="text-danger">*</span></label>
                    <input type="date" 
                           class="form-control @error('tanggal_daftar') is-invalid @enderror" 
                           id="tanggal_daftar" 
                           name="tanggal_daftar" 
                           value="{{ old('tanggal_daftar', $pendaftaran->tanggal_daftar) }}" 
                           required>
                    @error('tanggal_daftar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Pendaftaran <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="status" name="status" required>
                        <option value="pending" {{ old('status', $pendaftaran->status) == 'pending' ? 'selected' : '' }}>
                            ⏱️ Pending (Menunggu Konfirmasi)
                        </option>
                        <option value="diterima" {{ old('status', $pendaftaran->status) == 'diterima' ? 'selected' : '' }}>
                            ✅ Diterima
                        </option>
                        <option value="ditolak" {{ old('status', $pendaftaran->status) == 'ditolak' ? 'selected' : '' }}>
                            ❌ Ditolak
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i> Ubah status untuk menerima atau menolak pendaftaran siswa
                    </small>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
