@extends('layouts.mazer')

@section('title', 'Kelola Pendaftaran')
@section('page-title', 'Kelola Pendaftaran Siswa')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data Pendaftaran Siswa</h5>
            <a href="{{ route('pendaftaran.create-admin') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Pendaftaran
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
                            <th>Nama Siswa</th>
                            <th>NISN</th>
                            <th>Jurusan</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftarans as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{-- Foto Profil Siswa --}}
                                    @if($p->siswa->foto)
                                        <img src="{{ asset('storage/' . $p->siswa->foto) }}" 
                                             alt="Foto {{ $p->siswa->nama }}" 
                                             class="rounded-circle"
                                             style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #435ebe;">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($p->siswa->nama) }}&size=45&background=435ebe&color=fff" 
                                             alt="Avatar {{ $p->siswa->nama }}" 
                                             class="rounded-circle"
                                             style="width: 45px; height: 45px; border: 2px solid #435ebe;">
                                    @endif
                                </td>
                                <td><strong>{{ $p->siswa->nama }}</strong></td>
                                <td>{{ $p->siswa->nisn }}</td>
                                <td>{{ $p->jurusan->nama_jurusan }} ({{ $p->jurusan->kode_jurusan }})</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d/m/Y') }}</td>
                                <td>
                                    @if($p->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($p->status == 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('pendaftaran.edit', $p->id) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('pendaftaran.destroy', $p->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin hapus data ini?')"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted mt-2">Belum ada data pendaftaran</p>
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
