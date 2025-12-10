@extends('layouts.mazer')

@section('title', 'Biodata Siswa')
@section('page-title', 'Lengkapi Biodata Anda')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                @if($siswa)
                    Edit Biodata Siswa
                @else
                    Isi Biodata Siswa
                @endif
            </h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(!$siswa)
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    Lengkapi biodata Anda terlebih dahulu sebelum mendaftar jurusan.
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Terdapat kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('profile.biodata.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Preview Foto --}}
                <div class="mb-4 text-center">
                    <div class="mb-3">
                        @if($siswa && $siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" 
                                 alt="Foto Profil" 
                                 class="rounded-circle"
                                 id="preview-foto"
                                 style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #435ebe;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&size=150&background=435ebe&color=fff" 
                                 alt="Foto Profil" 
                                 class="rounded-circle"
                                 id="preview-foto"
                                 style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #435ebe;">
                        @endif
                    </div>
                    <label for="foto" class="btn btn-sm btn-primary">
                        <i class="bi bi-camera"></i> Upload Foto Profil
                    </label>
                    <input type="file" 
                           class="d-none @error('foto') is-invalid @enderror" 
                           id="foto" 
                           name="foto" 
                           accept="image/jpeg,image/jpg,image/png"
                           onchange="previewImage(event)">
                    @error('foto')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <small class="text-muted d-block mt-2">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama', $siswa->nama ?? '') }}" 
                           required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nisn" class="form-label">NISN (10 Digit) <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('nisn') is-invalid @enderror" 
                           id="nisn" 
                           name="nisn" 
                           value="{{ old('nisn', $siswa->nisn ?? '') }}" 
                           maxlength="10"
                           required>
                    @error('nisn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Nomor Induk Siswa Nasional</small>
                </div>

                <div class="mb-3">
                    <label for="asal_sekolah" class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('asal_sekolah') is-invalid @enderror" 
                           id="asal_sekolah" 
                           name="asal_sekolah" 
                           value="{{ old('asal_sekolah', $siswa->asal_sekolah ?? '') }}" 
                           required>
                    @error('asal_sekolah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                              id="alamat" 
                              name="alamat" 
                              rows="3" 
                              required>{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('no_hp') is-invalid @enderror" 
                           id="no_hp" 
                           name="no_hp" 
                           value="{{ old('no_hp', $siswa->no_hp ?? '') }}" 
                           required>
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Biodata
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- JavaScript untuk Preview Foto --}}
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-foto').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
