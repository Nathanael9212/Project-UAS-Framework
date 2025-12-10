<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Pendaftaran Siswa</title>

    {{-- CSS Mazer dari CDN --}}
    <link rel="stylesheet" crossorigin href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- Custom CSS --}}
    <style>
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }
        .stats-icon i {
            color: white;
        }
        .stats-icon.purple { background-color: #6366f1; }
        .stats-icon.blue { background-color: #3b82f6; }
        .stats-icon.green { background-color: #10b981; }
        .stats-icon.red { background-color: #ef4444; }
        
        #main { margin-left: 300px; }
        #sidebar { width: 300px; }
        
        @media (max-width: 1199px) {
            #main { margin-left: 0; }
        }

        .sidebar-item.active .sidebar-link {
            background-color: #435ebe;
            color: white;
        }

        .sidebar-user {
            border-bottom: 1px solid rgba(0,0,0,.1);
        }

        .sidebar-user img {
            box-shadow: 0 2px 5px rgba(0,0,0,.1);
        }
    </style>
</head>

<body>
    <div id="app">
        {{-- Sidebar --}}
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="{{ route('dashboard') }}">
                                <h4 class="mb-0">Pendaftaran Siswa</h4>
                            </a>
                        </div>
                    </div>
                    
                    {{-- Info User + Foto Profil di Sidebar --}}
                    @auth
                        <div class="sidebar-user mt-3 pb-3 d-flex align-items-center">
                            @if(Auth::user()->role == 'siswa' && Auth::user()->siswa && Auth::user()->siswa->foto)
                                <img src="{{ asset('storage/' . Auth::user()->siswa->foto) }}" 
                                     alt="Foto {{ Auth::user()->name }}" 
                                     class="rounded-circle me-2"
                                     style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #435ebe;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=45&background=435ebe&color=fff" 
                                     alt="Avatar {{ Auth::user()->name }}" 
                                     class="rounded-circle me-2"
                                     style="width: 45px; height: 45px; border: 2px solid #435ebe;">
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-0" style="font-size: 0.9rem;">{{ Str::limit(Auth::user()->name, 20) }}</h6>
                                <small class="text-muted">
                                    @if(Auth::user()->role == 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif(Auth::user()->role == 'petugas')
                                        <span class="badge bg-warning">Petugas</span>
                                    @else
                                        <span class="badge bg-primary">Siswa</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    @endauth
                </div>

                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                
                        <li class="sidebar-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                
                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'petugas')
                            {{-- Menu untuk Admin/Petugas --}}
                            <li class="sidebar-item {{ Request::routeIs('siswa.*') ? 'active' : '' }}">
                                <a href="{{ route('siswa.index') }}" class="sidebar-link">
                                    <i class="bi bi-people-fill"></i>
                                    <span>Data Siswa</span>
                                </a>
                            </li>
                
                            <li class="sidebar-item {{ Request::routeIs('jurusan.*') ? 'active' : '' }}">
                                <a href="{{ route('jurusan.index') }}" class="sidebar-link">
                                    <i class="bi bi-book-fill"></i>
                                    <span>Data Jurusan</span>
                                </a>
                            </li>
                
                            <li class="sidebar-item {{ Request::routeIs('pendaftaran.index') || Request::routeIs('pendaftaran.edit') || Request::routeIs('pendaftaran.create-admin') ? 'active' : '' }}">
                                <a href="{{ route('pendaftaran.index') }}" class="sidebar-link">
                                    <i class="bi bi-file-earmark-text-fill"></i>
                                    <span>Kelola Pendaftaran</span>
                                </a>
                            </li>
                        @else
                            {{-- Menu untuk Siswa --}}
                            <li class="sidebar-item {{ Request::routeIs('profile.biodata') ? 'active' : '' }}">
                                <a href="{{ route('profile.biodata') }}" class="sidebar-link">
                                    <i class="bi bi-person-fill"></i>
                                    <span>Biodata Saya</span>
                                </a>
                            </li>
                        
                            <li class="sidebar-item {{ Request::routeIs('pendaftaran.my') ? 'active' : '' }}">
                                <a href="{{ route('pendaftaran.my') }}" class="sidebar-link">
                                    <i class="bi bi-clipboard-check"></i>
                                    <span>Status Pendaftaran</span>
                                </a>
                            </li>
                        
                            <li class="sidebar-item {{ Request::routeIs('pendaftaran.list') ? 'active' : '' }}">
                                <a href="{{ route('pendaftaran.list') }}" class="sidebar-link">
                                    <i class="bi bi-people"></i>
                                    <span>Daftar Pendaftar</span>
                                </a>
                            </li>
                        
                            <li class="sidebar-item {{ Request::routeIs('pendaftaran.create') ? 'active' : '' }}">
                                <a href="{{ route('pendaftaran.create') }}" class="sidebar-link">
                                    <i class="bi bi-plus-circle"></i>
                                    <span>Daftar Jurusan</span>
                                </a>
                            </li>
                        @endif
                
                        <li class="sidebar-item">
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="#" class="sidebar-link" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-left"></i>
                                    <span>Logout</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>@yield('page-title', 'Dashboard')</h3>
            </div>

            <div class="page-content">
                @yield('content')
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>{{ date('Y') }} &copy; Sistem Pendaftaran Siswa Baru</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- JS Mazer --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>
</body>
</html>
