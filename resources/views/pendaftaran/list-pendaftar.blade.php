@extends('layouts.mazer')

@section('title', 'Daftar Pendaftar')
@section('page-title', 'Daftar Pendaftar Jurusan')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Siswa yang Telah Mendaftar</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama Siswa</th>
                            <th>Asal Sekolah</th>
                            <th>Jurusan</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
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
                                <td>{{ $p->siswa->asal_sekolah }}</td>
                                <td>{{ $p->jurusan->nama_jurusan }} ({{ $p->jurusan->kode_jurusan }})</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d/m/Y') }}</td>
                                <td>
                                    @if($p->status == 'pending')
                                        <span class="badge bg-warning">
                                            <i class="bi bi-clock"></i> Menunggu
                                        </span>
                                    @elseif($p->status == 'diterima')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Diterima
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted mt-2">Belum ada pendaftar</p>
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
