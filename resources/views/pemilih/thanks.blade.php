@extends('pemilih.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6"> {{-- Breakpoint responsive --}}
            <div class="card border-success shadow">
                <div class="card-body text-center p-3 p-md-4 p-lg-5"> {{-- Padding responsive --}}
                    {{-- Icon Success --}}
                    <div class="mb-3 mb-md-4"> {{-- Margin responsive --}}
                        <i class="fas fa-check-circle text-success"
                           style="font-size: clamp(3rem, 15vw, 5rem);"> {{-- Font size responsive --}}
                        </i>
                    </div>

                    {{-- Title --}}
                    <h2 class="text-success mb-2 mb-md-3 fw-bold fs-1 fs-md-2"> {{-- Font size responsive --}}
                        Terima Kasih!
                    </h2>

                    {{-- Message --}}
                    <p class="lead mb-3 mb-md-4 fs-6 fs-md-5"> {{-- Font size responsive --}}
                        Anda telah menggunakan hak pilih Anda dalam Pemilihan Ketua OSIS SMK PGRI 5 Jember.
                    </p>

                    {{-- Informasi Pemilih Card --}}
                    <div class="card bg-light border-0 mb-3 mb-md-4">
                        <div class="card-body p-3 p-md-4">
                            <h5 class="card-title mb-2 mb-md-3 text-primary fw-bold fs-5 fs-md-5">
                                <i class="fas fa-user-graduate me-2"></i>
                                <span class="d-none d-sm-inline">Informasi Pemilih</span>
                                <span class="d-inline d-sm-none">Data Pemilih</span>
                            </h5>
                            <div class="row text-start">
                                <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                                    <p class="mb-1 small">
                                        <strong class="text-dark">Nama:</strong><br>
                                        <span class="text-muted">{{ $pemilih->nama }}</span>
                                    </p>
                                </div>
                                <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                                    <p class="mb-1 small">
                                        <strong class="text-dark">NISN:</strong><br>
                                        <span class="text-muted">{{ $pemilih->nisn }}</span>
                                    </p>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <p class="mb-0 small">
                                        <strong class="text-dark">Kelas:</strong><br>
                                        <span class="text-muted">{{ $pemilih->kelas }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Alert Info --}}
                    <div class="alert alert-info mb-4 mb-md-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle me-2 mt-1 flex-shrink-0"></i>
                            <div class="text-start">
                                <strong>Informasi:</strong>
                                <span class="d-none d-md-inline">
                                    Hasil pemilihan akan diumumkan setelah proses voting selesai.
                                </span>
                                <span class="d-inline d-md-none">
                                    Hasil akan diumumkan setelah voting selesai.
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-4 mt-md-4">
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                            <a href="{{ route('pemilih.dashboard') }}"
                               class="btn btn-primary flex-fill flex-sm-grow-0 py-2 px-3">
                                <i class="fas fa-home me-1 me-sm-2"></i>
                                <span class="d-none d-sm-inline">Kembali ke Dashboard</span>
                                <span class="d-inline d-sm-none">Dashboard</span>
                            </a>
                            <a href="{{ route('logout') }}"
                               class="btn btn-outline-secondary flex-fill flex-sm-grow-0 py-2 px-3"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1 me-sm-2"></i>
                                <span class="d-none d-sm-inline">Logout</span>
                                <span class="d-inline d-sm-none">Keluar</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"  class="d-none">
                                @csrf
                                {{-- <button type="submit"> <i class="fas fa-sign-aout-alt"></i> Logout</button> --}}
                            </form>
                        </div>
                    </div>

                    {{-- Additional Info for Mobile --}}
                    <div class="mt-4 mt-md-4 d-block d-md-none">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Waktu voting: {{ now()->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Custom responsive styles */
    .card {
        border-width: 3px !important;
    }

    /* Smooth transitions for better mobile experience */
    .btn {
        transition: all 0.2s ease-in-out;
        min-height: 44px; /* Minimum touch target size */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    /* Responsive icon sizing */
    @media (max-width: 576px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .alert .d-flex {
            align-items: flex-start;
        }
    }

    /* Desktop optimizations */
    @media (min-width: 768px) {
        .card {
            border-width: 4px !important;
        }

        .btn {
            padding: 0.75rem 1.5rem;
        }
    }

    /* Large desktop optimizations */
    @media (min-width: 1200px) {
        .card-body {
            padding: 3rem !important;
        }
    }

    /* Animation for success icon */
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }

    .fa-check-circle {
        animation: bounce 2s ease-in-out;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced touch experience for mobile
        const buttons = document.querySelectorAll('.btn');

        buttons.forEach(button => {
            button.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });

            button.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Add some interactive feedback
        const successIcon = document.querySelector('.fa-check-circle');
        if (successIcon) {
            setTimeout(() => {
                successIcon.style.transition = 'all 0.3s ease';
                successIcon.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    successIcon.style.transform = 'scale(1)';
                }, 300);
            }, 1000);
        }
    });
</script>
@endpush
