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
            padding: 100px 0;
        }

        .login-options .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-options .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }

        .feature-icon {
            transition: transform 0.3s ease;
        }

        .feature-icon:hover {
            transform: scale(1.1);
        }

        /* Desktop/Laptop Optimization */
        @media (min-width: 1200px) {
            .hero-section {
                padding: 120px 0;
            }

            .hero-section h1 {
                font-size: 3.5rem;
                margin-bottom: 1.5rem !important;
            }

            .hero-section .lead {
                font-size: 1.5rem;
                margin-bottom: 1rem !important;
            }

            .card-body {
                padding: 3rem !important;
            }

            .login-options .card {
                min-height: 380px;
                display: flex;
                align-items: center;
            }

            .feature-icon {
                font-size: 2.5rem !important;
                margin-bottom: 1.5rem !important;
            }

            .feature-section h5 {
                font-size: 1.3rem;
            }

            .feature-section p {
                font-size: 1.1rem;
            }
        }

        @media (min-width: 992px) and (max-width: 1199px) {
            .hero-section {
                padding: 100px 0;
            }

            .hero-section h1 {
                font-size: 3rem;
            }

            .card-body {
                padding: 2.5rem !important;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .hero-section {
                padding: 80px 0;
            }

            .hero-section h1 {
                font-size: 2.5rem;
            }
        }

        /* Mobile Optimization */
        @media (max-width: 767px) {
            .hero-section {
                padding: 60px 0;
            }

            .hero-section h1 {
                font-size: 1.8rem;
            }

            .hero-section .lead {
                font-size: 1.1rem;
            }

            .card-body {
                padding: 2rem !important;
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

        /* Common Styles */
        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navigation -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-vote-yea me-2"></i>PEMILOS SMK PGRI 5 JEMBER
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="fw-bold mb-4">
                <i class="fas fa-vote-yea mb-3"></i><br>
                SISTEM PEMILIHAN KETUA OSIS
            </h1>
            <p class="lead mb-3">SMK PGRI 5 JEMBER</p>
            <p class="mb-0 fs-5 opacity-90">"Mewujudkan Pemilihan yang Demokratis, Transparan, dan Akuntabel"</p>
        </div>
    </section>

    <!-- Login Options -->
    <section class="py-5 login-options">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-5 col-12 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-user-graduate fa-2x text-white"></i>
                            </div>
                            <h4 class="card-title text-primary mb-3">Login Pemilih</h4>
                            <p class="card-text text-muted mb-4">
                                Login menggunakan NISN dan password untuk melakukan voting
                            </p>
                            <a href="{{ route('pemilih.login') }}" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Login sebagai Pemilih
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5 col-md-5 col-12 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-user-shield fa-2x text-white"></i>
                            </div>
                            <h4 class="card-title text-success mb-3">Login Admin</h4>
                            <p class="card-text text-muted mb-4">
                                Login sebagai administrator untuk mengelola sistem pemilihan
                            </p>
                            <a href="{{ url('/admin/login') }}" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Login sebagai Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information Section -->
    <section class="bg-light py-5 feature-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-4 col-md-4 col-12 mb-4">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3 feature-icon"></i>
                    <h5 class="fw-bold">Aman dan Terpercaya</h5>
                    <p class="text-muted">Sistem yang aman dengan enkripsi data untuk keamanan pemilihan</p>
                </div>
                <div class="col-lg-4 col-md-4 col-12 mb-4">
                    <i class="fas fa-bolt fa-3x text-success mb-3 feature-icon"></i>
                    <h5 class="fw-bold">Real-time Results</h5>
                    <p class="text-muted">Hasil pemilihan dapat dilihat secara real-time dan transparan</p>
                </div>
                <div class="col-lg-4 col-md-4 col-12 mb-4">
                    <i class="fas fa-users fa-3x text-warning mb-3 feature-icon"></i>
                    <h5 class="fw-bold">Transparan</h5>
                    <p class="text-muted">Proses pemilihan yang transparan dan akuntabel untuk semua pihak</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0">&copy; 2024 Sistem Pemilihan OSIS - SMK PGRI 5 Jember. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
