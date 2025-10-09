<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pemilos SMK PGRI 5 Jember</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Hamburger Menu untuk Admin */
        .hamburger-btn-admin {
            width: 40px;
            height: 40px;
            background: transparent;
            color: white;
            border: none;
            display: none;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .sidebar-overlay-admin {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            display: none;
        }

        .sidebar-overlay-admin.active {
            display: block;
        }

        /* Sidebar untuk Desktop */
        .sidebar {
            min-height: calc(100vh - 56px);
        }

        /* Sidebar untuk Mobile */
        .sidebar-mobile {
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            height: 100vh;
            background: white;
            z-index: 9999;
            transition: left 0.3s ease;
            padding: 20px;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar-mobile.active {
            left: 0;
        }

        .sidebar-header-mobile {
            padding: 20px 0;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .nav-link-mobile {
            display: block;
            padding: 12px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .nav-link-mobile:hover,
        .nav-link-mobile.active {
            background: #0d6efd;
            color: white;
        }

        .nav-link-mobile i {
            width: 20px;
            margin-right: 10px;
        }

        /* Navbar mobile simplification */
        .navbar-text,
        .nav-link.text-white {
            display: none;
        }

        /* Mobile only */
        @media (max-width: 768px) {
            .hamburger-btn-admin {
                display: flex;
            }

            /* Sembunyikan sidebar desktop di mobile */
            .sidebar {
                display: none !important;
            }

            /* Sembunyikan user info dan logout di navbar */
            .navbar-text,
            .nav-link.text-white {
                display: none !important;
            }

            /* Adjust main content untuk mobile */
            main {
                margin-left: 0 !important;
                padding: 1rem !important;
            }
        }

        /* Desktop - sembunyikan hamburger dan sidebar mobile */
        @media (min-width: 769px) {
            .hamburger-btn-admin,
            .sidebar-overlay-admin,
            .sidebar-mobile {
                display: none !important;
            }

            .sidebar {
                display: block !important;
            }

            /* Tampilkan user info dan logout di desktop */
            .navbar-text,
            .nav-link.text-white {
                display: flex !important;
            }
        }
    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    @stack('style')
</head>

<body>
    <!-- Overlay untuk Mobile -->
    <div class="sidebar-overlay-admin" id="sidebarOverlayAdmin"></div>

    <!-- Sidebar Mobile -->
    <div class="sidebar-mobile" id="sidebarMobile">
        <div class="sidebar-header-mobile">
            <h5>Menu Admin</h5>
            <small class="text-muted">SMK PGRI 5 Jember</small>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link-mobile {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link-mobile {{ request()->routeIs('calon.index') ? 'active' : '' }}"
                   href="{{ route('calon.index') }}">
                    <i class="fas fa-users"></i> Data Calon
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link-mobile {{ request()->routeIs('pemilih.index') ? 'active' : '' }}"
                   href="{{ route('pemilih.index') }}">
                    <i class="fas fa-user-graduate"></i> Data Pemilih
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link-mobile {{ request()->routeIs('admin.results') ? 'active' : '' }}"
                   href="{{ route('admin.results') }}">
                    <i class="fas fa-chart-bar"></i> Hasil Realtime
                </a>
            </li>
        </ul>

        <!-- Tambahkan user info dan logout di sidebar mobile -->
        <div class="mt-4 pt-3 border-top">
            <div class="sidebar-user-info mb-3">
                <small class="text-muted d-block">
                    <i class="fas fa-user-shield"></i> {{ Auth::user()->name }}
                </small>
            </div>
            <a class="nav-link-mobile text-danger" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <!-- Hamburger Button yang menyatu dengan navbar -->
            <button class="hamburger-btn-admin" id="hamburgerAdmin">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-vote-yea"></i> Pemilos Admin
            </a>

            <div class="navbar-nav ms-auto">
                <span class="navbar-text text-white me-3">
                    <i class="fas fa-user-shield m-1"></i> {{ Auth::user()->name }}
                </span>
                <a class="nav-link text-white" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt m-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Desktop -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('calon.index') ? 'active' : '' }}"
                               href="{{ route('calon.index') }}">
                                <i class="fas fa-users"></i> Data Calon
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pemilih.index') ? 'active' : '' }}"
                               href="{{ route('pemilih.index') }}">
                                <i class="fas fa-user-graduate"></i> Data Pemilih
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.results') ? 'active' : '' }}"
                               href="{{ route('admin.results') }}">
                                <i class="fas fa-chart-bar"></i> Hasil Realtime
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Simple hamburger menu untuk admin
        const hamburgerAdmin = document.getElementById('hamburgerAdmin');
        const sidebarMobile = document.getElementById('sidebarMobile');
        const sidebarOverlayAdmin = document.getElementById('sidebarOverlayAdmin');

        // Buka sidebar
        hamburgerAdmin.addEventListener('click', function() {
            sidebarMobile.classList.add('active');
            sidebarOverlayAdmin.classList.add('active');
        });

        // Tutup sidebar
        function closeAdminMenu() {
            sidebarMobile.classList.remove('active');
            sidebarOverlayAdmin.classList.remove('active');
        }

        // Tutup ketika klik overlay
        sidebarOverlayAdmin.addEventListener('click', closeAdminMenu);

        // Tutup dengan ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAdminMenu();
            }
        });

        // Tutup ketika klik menu item
        const navLinks = document.querySelectorAll('.nav-link-mobile');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                setTimeout(closeAdminMenu, 300);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
