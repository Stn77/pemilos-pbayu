<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemilihan OSIS - SMK PGRI 5 Jember</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        footer {
            margin-top: auto;
            flex-shrink: 0;
        }

        .hamburger-btn {
            width: 44px;
            height: 44px;
            border: none;
            background: transparent;
            color: white;
            font-size: 1.2rem;
            display: none;
        }

        .sidebar-menu {
            position: fixed;
            top: 0;
            right: -300px;
            width: 280px;
            height: 100vh;
            background: white;
            z-index: 9999;
            transition: right 0.3s ease;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar-menu.active {
            right: 0;
        }

        .sidebar-item {
            display: block;
            padding: 12px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .sidebar-item:hover {
            background: #f8f9fa;
        }

        .sidebar-item i {
            width: 20px;
            margin-right: 10px;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            display: none;
        }

        .sidebar-overlay.active {
            display: block;
        }

        @media (max-width: 768px) {
            .hamburger-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .navbar-collapse {
                display: none !important;
            }
        }

        @media (min-width: 769px) {
            .sidebar-menu,
            .sidebar-overlay,
            .hamburger-btn {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('pemilih.dashboard') }}">
                <i class="fas fa-vote-yea m-2"></i>PEMILOS
            </a>

            <button class="hamburger-btn" id="hamburgerMenu">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pemilih.dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pemilih.profile') }}">
                            <i class="fas fa-user"></i> Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pemilih.voting') }}">
                            <i class="fas fa-vote-yea"></i> Voting
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pemilih.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('pemilih.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- humberger menu untuk mobile --}}
    <div class="sidebar-menu" id="sidebarMenu">
        <div class="mb-4">
            <h5>Menu Pemilih</h5>
            <small class="text-muted">SMK PGRI 5 Jember</small>
        </div>

        <a href="{{ route('pemilih.dashboard') }}" class="sidebar-item">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('pemilih.profile') }}" class="sidebar-item">
            <i class="fas fa-user"></i> Profil Saya
        </a>
        <a href="{{ route('pemilih.voting') }}" class="sidebar-item">
            <i class="fas fa-vote-yea"></i> Voting
        </a>
        <hr>
        <a href="{{ route('pemilih.logout') }}" class="sidebar-item text-danger"
            onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="sidebar-logout-form" action="{{ route('pemilih.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <small>&copy; 2024 Sistem Pemilihan OSIS - SMK PGRI 5 Jember</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('hamburgerMenu').onclick = function() {
            document.getElementById('sidebarMenu').classList.add('active');
            document.getElementById('sidebarOverlay').classList.add('active');
        };

        document.getElementById('sidebarOverlay').onclick = function() {
            document.getElementById('sidebarMenu').classList.remove('active');
            this.classList.remove('active');
        };

        function closeMenu() {
            document.getElementById('sidebarMenu').classList.remove('active');
            document.getElementById('sidebarOverlay').classList.remove('active');
        }
    </script>

    @stack('scripts')
</body>
</html>
