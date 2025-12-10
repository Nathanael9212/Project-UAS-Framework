@extends('layouts.mazer')

@section('title', 'Data Jurusan')
@section('page-title', 'Data Jurusan')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Jurusan</h5>
                <a href="{{ route('jurusan.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Jurusan
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Jurusan</th>
                            <th>Kode Jurusan</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jurusans as $index => $jurusan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $jurusan->nama_jurusan }}</td>
                                <td><span class="badge bg-primary">{{ $jurusan->kode_jurusan }}</span></td>
                                <td>{{ Str::limit($jurusan->deskripsi ?? '-', 50) }}</td>
                                <td>
                                    <a href="{{ route('jurusan.edit', $jurusan->id) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('jurusan.destroy', $jurusan->id) }}" 
                                          method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus jurusan ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada data jurusan
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
