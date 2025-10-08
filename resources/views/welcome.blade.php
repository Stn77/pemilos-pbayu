<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pemilihan OSIS - SMK PGRI 5 Jember</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }

        /* Hanya CSS untuk mobile */
        @media (max-width: 768px) {
            .hero-section {
                padding: 40px 0;
            }
            .hero-section h1 {
                font-size: 1.8rem;
            }
            .hero-section .lead {
                font-size: 1.1rem;
            }
            .card-body {
                padding: 25px !important;
            }
            .btn {
                padding: 12px;
                font-size: 16px;
                min-height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .navbar-brand {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-vote-yea"></i> PEMILOS SMK PGRI 5 JEMBER
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="fw-bold mb-3">
                <i class="fas fa-vote-yea"></i><br>
                SISTEM PEMILIHAN KETUA OSIS
            </h1>
            <p class="lead mb-3">SMK PGRI 5 JEMBER</p>
            <p class="mb-4">"Mewujudkan Pemilihan yang Demokratis, Transparan, dan Akuntabel"</p>
        </div>
    </section>

    <!-- Login Options -->
    <section class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-12 mb-3">
                    <div class="card shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 70px; height: 70px;">
                                <i class="fas fa-user-graduate fa-2x text-white"></i>
                            </div>
                            <h4 class="card-title text-primary">Login Pemilih</h4>
                            <p class="card-text text-muted mb-3">
                                Login menggunakan NISN dan password untuk melakukan voting
                            </p>
                            <a href="{{ route('pemilih.login') }}" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt"></i> Login sebagai Pemilih
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-12 mb-3">
                    <div class="card shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 70px; height: 70px;">
                                <i class="fas fa-user-shield fa-2x text-white"></i>
                            </div>
                            <h4 class="card-title text-success">Login Admin</h4>
                            <p class="card-text text-muted mb-3">
                                Login sebagai administrator untuk mengelola sistem pemilihan
                            </p>
                            <a href="{{ url('/admin/login') }}" class="btn btn-success w-100">
                                <i class="fas fa-sign-in-alt"></i> Login sebagai Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information Section -->
    <section class="bg-light py-4">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 col-12 mb-3">
                    <i class="fas fa-shield-alt fa-2x text-primary mb-2"></i>
                    <h5>Aman dan Terpercaya</h5>
                    <p class="text-muted">Sistem yang aman dengan enkripsi data</p>
                </div>
                <div class="col-md-4 col-12 mb-3">
                    <i class="fas fa-bolt fa-2x text-success mb-2"></i>
                    <h5>Real-time Results</h5>
                    <p class="text-muted">Hasil pemilihan dapat dilihat secara real-time</p>
                </div>
                <div class="col-md-4 col-12 mb-3">
                    <i class="fas fa-users fa-2x text-warning mb-2"></i>
                    <h5>Transparan</h5>
                    <p class="text-muted">Proses pemilihan yang transparan dan akuntabel</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p class="mb-0">&copy; 2024 Sistem Pemilihan OSIS - SMK PGRI 5 Jember. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
