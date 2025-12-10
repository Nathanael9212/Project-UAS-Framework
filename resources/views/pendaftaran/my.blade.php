@extends('layouts.mazer')

@section('title', 'Pendaftaran Saya')
@section('page-title', 'Pendaftaran Saya')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Riwayat Pendaftaran Jurusan</h5>
            <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Daftar Jurusan Baru
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-x-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(isset($message))
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                </div>
            @else
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
                                        <a href="{{ route('pendaftaran.create') }}" class="btn btn-sm btn-primary">
                                            Daftar Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
