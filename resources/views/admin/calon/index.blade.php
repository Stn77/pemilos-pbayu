@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Calon Ketua OSIS</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('calon.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span class="d-none d-md-inline">Tambah Calon</span>
                <span class="d-inline d-md-none">Tambah</span>
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body p-0">
            <!-- Desktop Table -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th width="50">#</th>
                            <th width="100">Foto</th>
                            <th>Nama Calon</th>
                            <th>Visi</th>
                            <th width="120">Jumlah Suara</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($calon as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    @if ($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_calon }}"
                                            class="rounded"
                                            style="width: 80px; height: 100px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                            style="width: 80px; height: 100px;">
                                            <i class="fas fa-user text-white fa-lg"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ $item->nama_calon }}</td>
                                <td>{{ Str::limit($item->visi, 50) }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary fs-6">{{ $item->jumlah_suara }} suara</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('calon.show', $item->id) }}" class="btn btn-info"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('calon.edit', $item->id) }}" class="btn btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('calon.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus calon ini?')"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-2x mb-2"></i>
                                        <p class="mb-0">Belum ada data calon.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-md-none p-2">
                @forelse($calon as $item)
                    <div class="card border shadow-sm mb-3">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <!-- Foto - PERSEGI PANJANG -->
                                <div class="col-4 text-center">
                                    @if ($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_calon }}"
                                            class="rounded img-fluid"
                                            style="width: 80px; height: 100px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center mx-auto"
                                            style="width: 80px; height: 100px;">
                                            <i class="fas fa-user text-white fa-lg"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Info Calon -->
                                <div class="col-8">
                                    <h6 class="card-title mb-1 fw-bold text-primary">{{ $item->nama_calon }}</h6>
                                    <p class="card-text small text-muted mb-2">
                                        <strong>Visi:</strong> {{ Str::limit($item->visi, 40) }}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="badge bg-primary">
                                            <i class="fas fa-chart-bar me-1"></i>
                                            {{ $item->jumlah_suara }} suara
                                        </span>
                                        <small class="text-muted">#{{ $loop->iteration }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Aksi Buttons -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-flex justify-content-between">
                                        <a href="{{ route('calon.show', $item->id) }}"
                                           class="btn btn-info btn-sm flex-fill d-flex align-items-center justify-content-center">
                                            <i class="fas fa-eye me-1"></i>
                                            <span class="d-none d-sm-inline">Detail</span>
                                        </a>
                                        <a href="{{ route('calon.edit', $item->id) }}"
                                           class="btn btn-warning btn-sm flex-fill d-flex align-items-center justify-content-center">
                                            <i class="fas fa-edit me-1"></i>
                                            <span class="d-none d-sm-inline">Edit</span>
                                        </a>
                                        <form action="{{ route('calon.destroy', $item->id) }}" method="POST"
                                              class="d-inline flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus calon ini?')">
                                                <i class="fas fa-trash me-1"></i>
                                                <span class="d-none d-sm-inline">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted mb-3">Belum ada data calon</h5>
                        <a href="{{ route('calon.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i> Tambah Calon Pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pagination - FIXED VERSION -->
    @if($calon instanceof \Illuminate\Pagination\AbstractPaginator && $calon->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <nav>
            {{ $calon->links() }}
        </nav>
    </div>
    @endif
@endsection

@push('styles')
<style>
    /* Mobile Optimization */
    @media (max-width: 767.98px) {
        .card-body {
            padding: 1rem !important;
        }

        .btn {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            padding: 0.5rem 0.75rem;
        }

        /* Card styling for mobile */
        .card.mb-3 {
            margin-bottom: 1rem !important;
            border-radius: 12px;
            border: 1px solid #dee2e6;
        }

        .card.mb-3:last-child {
            margin-bottom: 0.5rem !important;
        }

        /* Text optimization */
        .card-title {
            font-size: 1rem;
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }

        .card-text {
            font-size: 0.8rem;
            line-height: 1.3;
            margin-bottom: 0.75rem;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.4em 0.6em;
        }

        /* Button text responsive */
        .btn-sm .d-none.d-sm-inline {
            font-size: 0.75rem;
        }
    }

    /* Desktop table optimization */
    @media (min-width: 768px) {
        .table th, .table td {
            vertical-align: middle;
            padding: 0.75rem;
        }

        .btn-group .btn {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
        }

        .table img.rounded {
            border: 2px solid #f8f9fa;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    }

    /* Image styling */
    .rounded {
        border-radius: 8px !important;
    }

    /* Button group spacing */
    .btn-group {
        gap: 0.25rem;
    }

    .btn-group .btn {
        border-radius: 6px !important;
    }

    /* Empty state styling */
    .text-center.py-5 {
        padding: 3rem 1rem !important;
    }

    /* Pagination responsive */
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }

    .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }

    /* Hover effects */
    .card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        transition: box-shadow 0.2s ease-in-out;
    }

    /* Badge styling */
    .badge {
        font-weight: 500;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced touch experience for mobile
        const mobileCards = document.querySelectorAll('.card.mb-3');

        mobileCards.forEach(card => {
            card.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });

            card.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Confirm delete with sweet alert (optional)
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Apakah Anda yakin ingin menghapus calon ini? Data yang dihapus tidak dapat dikembalikan.')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endpush
