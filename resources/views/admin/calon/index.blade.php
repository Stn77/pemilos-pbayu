@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Calon Ketua OSIS</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('calon.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Tambah Calon</span>
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
                            <th width="80">Foto</th>
                            <th>Nama Calon</th>
                            <th>Visi</th>
                            <th width="120">Jumlah Suara</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($calon as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_calon }}"
                                            class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-user text-white"></i>
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
                                <td colspan="6" class="text-center py-4">Belum ada data calon.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-md-none">
                @forelse($calon as $item)
                    <div class="card m-3 border shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Foto dan Nama -->
                                <div class="col-3 text-center">
                                    @if ($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_calon }}"
                                            class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                            style="width: 60px; height: 60px;">
                                            <i class="fas fa-user text-white fa-lg"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-9">
                                    <h6 class="card-title mb-1 fw-bold">{{ $item->nama_calon }}</h6>
                                    <p class="card-text small text-muted mb-2">
                                        {{ Str::limit($item->visi, 60) }}
                                    </p>
                                    <span class="badge bg-primary">{{ $item->jumlah_suara }} suara</span>
                                </div>
                            </div>

                            <!-- Aksi Buttons -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-flex justify-content-between">
                                        <a href="{{ route('calon.show', $item->id) }}" class="btn btn-info btn-sm flex-fill">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('calon.edit', $item->id) }}" class="btn btn-warning btn-sm flex-fill">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('calon.destroy', $item->id) }}" method="POST" class="d-inline flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus calon ini?')">
                                                <i class="fas fa-trash"></i> Hapus
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
                        <p class="text-muted">Belum ada data calon.</p>
                        <a href="{{ route('calon.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Calon Pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

<style>
    /* Mobile Optimization */
    @media (max-width: 767.98px) {
        .card-body {
            padding: 0 !important;
        }

        .btn {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .btn-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
        }

        /* Card styling for mobile */
        .card.m-3 {
            margin: 0.75rem !important;
            border-radius: 10px;
        }

        .card.m-3:first-child {
            margin-top: 1rem !important;
        }

        .card.m-3:last-child {
            margin-bottom: 1rem !important;
        }

        /* Text optimization */
        .card-title {
            font-size: 1rem;
            line-height: 1.2;
        }

        .card-text {
            font-size: 0.85rem;
            line-height: 1.3;
        }

        .badge {
            font-size: 0.75rem;
        }
    }

    /* Desktop table optimization */
    @media (min-width: 768px) {
        .table th, .table td {
            vertical-align: middle;
        }

        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }
    }

    /* Ensure images are properly displayed */
    .rounded-circle {
        object-fit: cover;
    }

    /* Button group spacing */
    .btn-group {
        gap: 2px;
    }

    .btn-group .btn {
        border-radius: 4px !important;
    }

    /* Empty state styling */
    .text-center.py-5 {
        padding: 3rem 1rem !important;
    }
</style>
@endsection
