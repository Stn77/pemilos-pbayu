@extends('pemilih.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="card-title mb-0 text-center text-md-start">
                        <i class="fas fa-vote-yea me-2"></i> Pemilihan Ketua OSIS
                    </h4>
                </div>
                <div class="card-body p-2 p-md-4">
                    {{-- Alert Warning --}}
                    <div class="alert alert-warning mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-triangle me-2 mt-1 flex-shrink-0"></i>
                            <div>
                                <strong class="d-block mb-2">Perhatian!</strong>
                                <ul class="mb-0 ps-3">
                                    <li class="mb-1">Pilihlah calon dengan bijak dan penuh tanggung jawab</li>
                                    <li class="mb-1">Anda hanya dapat memilih <strong>satu kali</strong> saja</li>
                                    <li class="mb-1">Pilihan Anda tidak dapat diubah setelah submit</li>
                                    <li class="mb-0">Pastikan memilih sesuai dengan hati nurani</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- MOBILE LAYOUT (Collapsible) --}}
                    <div class="d-block d-md-none">
                        <div class="row justify-content-center">
                            @foreach ($calon as $c)
                                <div class="col-12 mb-3">
                                    <div class="card card-calon-mobile border-primary shadow-sm"
                                         data-bs-toggle="collapse"
                                         data-bs-target="#detailCollapse{{ $c->id }}"
                                         aria-expanded="false"
                                         style="cursor: pointer; transition: all 0.3s ease;">

                                        {{-- Card Header - Always Visible --}}
                                        <div class="card-header bg-light py-3">
                                            <div class="row align-items-center">
                                                {{-- Foto dan Nama - PERSEGI PANJANG --}}
                                                <div class="col-auto">
                                                    @if ($c->foto)
                                                        <img src="{{ asset('storage/' . $c->foto) }}"
                                                             alt="{{ $c->nama_calon }}"
                                                             class="img-fluid rounded"
                                                             style="width: 60px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                                             style="width: 60px; height: 80px;">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <h5 class="card-title mb-0 text-primary fw-bold">
                                                        {{ $c->nama_calon }}
                                                    </h5>
                                                    <small class="text-muted">Ketuk untuk melihat detail</small>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-chevron-down text-primary transition-rotate"></i>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Collapsible Content --}}
                                        <div class="collapse" id="detailCollapse{{ $c->id }}">
                                            <div class="card-body bg-white">
                                                {{-- Foto Besar di Detail - PERSEGI PANJANG --}}
                                                <div class="text-center mb-3">
                                                    @if ($c->foto)
                                                        <img src="{{ asset('storage/' . $c->foto) }}"
                                                             alt="{{ $c->nama_calon }}"
                                                             class="img-fluid rounded mb-3"
                                                             style="width: 200px; height: 250px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary rounded d-inline-flex align-items-center justify-content-center mb-3"
                                                             style="width: 200px; height: 250px;">
                                                            <i class="fas fa-user text-white fa-3x"></i>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Visi --}}
                                                <div class="mb-3">
                                                    <h6 class="text-primary fw-bold mb-2">
                                                        <i class="fas fa-bullseye me-1"></i> Visi
                                                    </h6>
                                                    <p class="mb-0 text-dark" style="line-height: 1.5;">
                                                        {{ $c->visi }}
                                                    </p>
                                                </div>

                                                {{-- Misi --}}
                                                <div class="mb-3">
                                                    <h6 class="text-primary fw-bold mb-2">
                                                        <i class="fas fa-tasks me-1"></i> Misi
                                                    </h6>
                                                    <div class="ps-3">
                                                        @foreach ($c->misi as $index => $misi)
                                                            <div class="mb-2">
                                                                <strong class="text-dark small">Misi {{ $index + 1 }}:</strong>
                                                                <p class="mb-1 small text-dark" style="line-height: 1.4;">
                                                                    {{ $misi->misi }}
                                                                </p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                {{-- Action Button --}}
                                                <div class="text-center mt-4">
                                                    <form action="{{ route('pemilih.vote', $c->id) }}" method="POST" class="w-100">
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-success btn-lg w-100 py-3 fw-bold"
                                                                onclick="return confirmVote('{{ $c->nama_calon }}')">
                                                            <i class="fas fa-check-circle me-2"></i>
                                                            PILIH {{ Str::upper($c->nama_calon) }}
                                                        </button>
                                                    </form>
                                                    <small class="text-muted mt-2 d-block">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Pilihan tidak dapat diubah setelah submit
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- DESKTOP LAYOUT --}}
                    <div class="d-none d-md-block">
                        <div class="row justify-content-center">
                            @foreach ($calon as $c)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card card-calon h-100 border-primary shadow-sm">
                                        <div class="card-header bg-light text-center py-3">
                                            <h5 class="card-title mb-0 text-primary fw-bold">
                                                {{ $c->nama_calon }}
                                            </h5>
                                        </div>

                                        <div class="card-body text-center">
                                            {{-- Foto Calon - PERSEGI PANJANG --}}
                                            @if ($c->foto)
                                                <img src="{{ asset('storage/' . $c->foto) }}" alt="{{ $c->nama_calon }}"
                                                    class="img-fluid rounded mb-3"
                                                    style="width: 180px; height: 220px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary rounded d-inline-flex align-items-center justify-content-center mb-3"
                                                    style="width: 180px; height: 220px;">
                                                    <i class="fas fa-user fa-2x text-white"></i>
                                                </div>
                                            @endif

                                            <h6 class="text-primary fw-bold">Visi</h6>
                                            <p class="card-text small">{{ Str::limit($c->visi, 100) }}</p>

                                            <h6 class="text-primary fw-bold">Misi</h6>
                                            @foreach ($c->misi as $misi)
                                            <p class="card-text small">{{ Str::limit($misi->misi, 100) }}</p>
                                            @endforeach

                                            <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                                data-bs-toggle="modal" data-bs-target="#detailModal{{ $c->id }}">
                                                <i class="fas fa-eye"></i> Lihat Detail
                                            </button>
                                        </div>

                                        <div class="card-footer bg-transparent text-center">
                                            <form action="{{ route('pemilih.vote', $c->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-lg px-4"
                                                    onclick="return confirmVote('{{ $c->nama_calon }}')">
                                                    <i class="fas fa-check-circle"></i> Pilih
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Detail untuk Desktop --}}
                                <div class="modal fade" id="detailModal{{ $c->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Profil Calon - {{ $c->nama_calon }}</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row align-items-start">
                                                    <div class="col-md-4 text-center">
                                                        {{-- Foto Modal - PERSEGI PANJANG --}}
                                                        @if ($c->foto)
                                                            <img src="{{ asset('storage/' . $c->foto) }}"
                                                                alt="{{ $c->nama_calon }}"
                                                                class="img-fluid rounded mb-3"
                                                                style="width: 100%; max-width: 250px; height: 300px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-3 mx-auto"
                                                                style="width: 250px; height: 300px;">
                                                                <i class="fas fa-user fa-3x text-white"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h5 class="text-primary">Visi</h5>
                                                        <p>{{ $c->visi }}</p>

                                                        <h5 class="text-primary mt-4">Misi</h5>
                                                        @foreach ($c->misi as $misi)
                                                        <div style="white-space: pre-line;">{{ $misi->misi }}</div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times"></i> Tutup
                                                </button>
                                                <form action="{{ route('pemilih.vote', $c->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success"
                                                        onclick="return confirmVote('{{ $c->nama_calon }}')">
                                                        <i class="fas fa-check-circle"></i> Pilih Kandidat Ini
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Empty State --}}
                    @if ($calon->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum ada calon yang terdaftar</h4>
                            <p class="text-muted">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Mobile Card Styles */
    .card-calon-mobile {
        border-left: 4px solid #0d6efd;
        transition: all 0.3s ease;
    }

    .card-calon-mobile:hover {
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.2);
    }

    .card-calon-mobile[aria-expanded="true"] {
        box-shadow: 0 4px 20px rgba(13, 110, 253, 0.3);
    }

    .card-calon-mobile[aria-expanded="true"] .transition-rotate {
        transform: rotate(180deg);
    }

    .transition-rotate {
        transition: transform 0.3s ease;
    }

    /* Desktop card hover effects */
    .card-calon {
        transition: transform 0.2s ease-in-out;
    }

    .card-calon:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }

    /* Image styling */
    .rounded {
        border-radius: 8px !important;
    }

    /* Button optimization for mobile */
    @media (max-width: 767.98px) {
        .btn {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Konfirmasi vote sederhana
    function confirmVote(namaCalon) {
        return confirm(`Apakah Anda yakin memilih ${namaCalon}?\n\n⚠️ Pilihan tidak dapat diubah setelah dikonfirmasi!`);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced touch experience for mobile cards
        const mobileCards = document.querySelectorAll('.card-calon-mobile');

        mobileCards.forEach(card => {
            // Add click effect
            card.addEventListener('click', function() {
                // Remove active state from all cards
                mobileCards.forEach(c => {
                    if (c !== this) {
                        c.classList.remove('active');
                        const collapse = c.querySelector('.collapse');
                        if (collapse && collapse.classList.contains('show')) {
                            bootstrap.Collapse.getInstance(collapse).hide();
                        }
                    }
                });
            });

            // Touch feedback
            card.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });

            card.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Prevent form buttons from triggering collapse
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    });
</script>
@endpush
