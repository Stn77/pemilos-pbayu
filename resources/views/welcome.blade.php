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

        .login-options {
            margin-top: 50px;
        }

        .card-hover {
            transition: transform 0.3s;
        }

        .card-hover:hover {
            transform: translateY(-10px);
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-vote-yea"></i> PEMILOS SMK PGRI 5 JEMBER
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">
                <i class="fas fa-vote-yea"></i><br>
                SISTEM PEMILIHAN KETUA OSIS
            </h1>
            <p class="lead mb-4">SMK PGRI 5 JEMBER</p>
            <p class="mb-5">"Mewujudkan Pemilihan yang Demokratis, Transparan, dan Akuntabel"</p>
        </div>
    </section>

    <!-- Login Options -->
    <section class="login-options">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 mb-4">
                    <div class="card card-hover shadow border-0">
                        <div class="card-body text-center p-5">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-user-graduate fa-2x text-white"></i>
                            </div>
                            <h4 class="card-title text-primary">Login Pemilih</h4>
                            <p class="card-text text-muted mb-4">
                                Login menggunakan NISN dan password untuk melakukan voting
                            </p>
                            <a href="{{ route('pemilih.login') }}" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-sign-in-alt"></i> Login sebagai Pemilih
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 mb-4">
                    <div class="card card-hover shadow border-0">
                        <div class="card-body text-center p-5">
                            <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-user-shield fa-2x text-white"></i>
                            </div>
                            <h4 class="card-title text-success">Login Admin</h4>
                            <p class="card-text text-muted mb-4">
                                Login sebagai administrator untuk mengelola sistem pemilihan
                            </p>
                            <a href="{{ url('/admin/login') }}" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-sign-in-alt"></i> Login sebagai Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information Section -->
    <section class="bg-light py-5 mt-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h5>Aman dan Terpercaya</h5>
                    <p class="text-muted">Sistem yang aman dengan enkripsi data</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="fas fa-bolt fa-3x text-success mb-3"></i>
                    <h5>Real-time Results</h5>
                    <p class="text-muted">Hasil pemilihan dapat dilihat secara real-time</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="fas fa-users fa-3x text-warning mb-3"></i>
                    <h5>Transparan</h5>
                    <p class="text-muted">Proses pemilihan yang transparan dan akuntabel</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; 2024 Sistem Pemilihan OSIS - SMK PGRI 5 Jember. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
