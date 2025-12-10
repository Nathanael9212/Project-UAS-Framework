@extends('layouts.mazer')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Siswa</h5>
            <a href="{{ route('siswa.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Siswa
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>NISN</th>
                            <th>Asal Sekolah</th>
                            <th>No HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $siswa)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{-- Foto Profil Siswa --}}
                                    @if($siswa->foto)
                                        <img src="{{ asset('storage/' . $siswa->foto) }}" 
                                             alt="Foto {{ $siswa->nama }}" 
                                             class="rounded-circle"
                                             style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #435ebe;">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama) }}&size=50&background=435ebe&color=fff" 
                                             alt="Avatar {{ $siswa->nama }}" 
                                             class="rounded-circle"
                                             style="width: 50px; height: 50px; border: 2px solid #435ebe;">
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $siswa->nama }}</strong>
                                    @if($siswa->user)
                                        <br><small class="text-muted">{{ $siswa->user->email }}</small>
                                    @endif
                                </td>
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->asal_sekolah }}</td>
                                <td>{{ $siswa->no_hp }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('siswa.edit', $siswa->id) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('siswa.destroy', $siswa->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin hapus data siswa {{ $siswa->nama }}? Data pendaftaran siswa ini juga akan terhapus!')"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted mt-2">Belum ada data siswa</p>
                                    <a href="{{ route('siswa.create') }}" class="btn btn-sm btn-primary">
                                        Tambah Siswa Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
