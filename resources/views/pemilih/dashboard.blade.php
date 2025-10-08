@extends('pemilih.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card profile-card shadow mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8 col-12 mb-3 mb-md-0">
                            <h3 class="card-title mb-1">
                                <i class="fas fa-user-graduate"></i> Selamat Datang, {{ $pemilih->nama }}!
                            </h3>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-id-card"></i> NISN: {{ $pemilih->nisn }} |
                                <i class="fas fa-users"></i> Kelas: {{ $pemilih->kelas }}
                            </p>
                        </div>
                        <div class="col-md-4 col-12 text-md-end text-center">
                            @if ($pemilih->sudah_memilih)
                                <span class="badge bg-success fs-6 p-2">
                                    <i class="fas fa-check-circle"></i> Sudah Memilih
                                </span>
                            @else
                                <span class="badge bg-warning fs-6 p-2">
                                    <i class="fas fa-clock"></i> Belum Memilih
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if ($pemilih->sudah_memilih)
            <div class="col-12">
                <div class="card border-success shadow">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-check-circle text-success display-1 mb-3"></i>
                        <h3 class="text-success">Terima Kasih!</h3>
                        <p class="lead">Anda sudah menggunakan hak pilih Anda.</p>
                        <a href="{{ route('pemilih.thanks') }}" class="btn btn-success btn-lg mt-3">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-6 col-12 mb-4">
                <div class="card border-primary shadow h-100">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-vote-yea text-primary display-1 mb-3"></i>
                        <h4 class="text-primary">Pemilihan Ketua OSIS</h4>
                        <p class="text-muted">Gunakan hak pilih Anda.</p>
                        <a href="{{ route('pemilih.voting') }}" class="btn btn-primary btn-lg mt-3 w-100">
                            <i class="fas fa-play-circle"></i> Mulai Voting
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-4">
                <div class="card border-info shadow h-100">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-users text-info display-1 mb-3"></i>
                        <h4 class="text-info">Kandidat Calon</h4>
                        <p class="text-muted">Lihat profil calon ketua OSIS.</p>
                        <div class="mt-3">
                            <span class="badge bg-info fs-6 p-2">{{ $calon->count() }} Kandidat</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if (!$pemilih->sudah_memilih && $calon->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-users"></i> Daftar Calon Ketua OSIS
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Desktop View - dengan detail -->
                        <div class="row d-none d-md-flex">
                            @foreach ($calon as $c)
                                <div class="col-md-4 mb-3">
                                    <div class="card card-calon border">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-user-circle fa-3x text-secondary"></i>
                                            </div>
                                            <h6 class="card-title">{{ $c->nama_calon }}</h6>
                                            <p class="card-text small text-muted">
                                                {{ Str::limit($c->visi, 50) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Mobile View - hanya foto -->
                        <div class="row d-md-none">
                            @foreach ($calon as $c)
                                <div class="col-4 col-sm-3 mb-3">
                                    <div class="text-center">
                                        <div class="calon-photo-mobile mx-auto">
                                            <i class="fas fa-user-circle"></i>
                                        </div>
                                        <small class="d-block mt-1">{{ $c->nama_calon }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('pemilih.voting') }}" class="btn btn-primary">
                                <i class="fas fa-vote-yea"></i> Lihat Detail dan Voting
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

<style>
    /* Foto calon untuk mobile */
    .calon-photo-mobile {
        width: 70px;
        height: 70px;
        background: #f8f9fa;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #6c757d;
        border: 2px solid #dee2e6;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .btn-lg {
            padding: 12px;
            font-size: 16px;
        }

        .display-1 {
            font-size: 3rem;
        }

        /* Grid untuk foto calon */
        .col-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-sm-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
    }

    @media (max-width: 576px) {
        .calon-photo-mobile {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .col-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
    }

    @media (max-width: 400px) {
        .col-4 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .calon-photo-mobile {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }
    }
</style>
@endsection
