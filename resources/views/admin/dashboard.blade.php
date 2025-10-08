@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Admin</h1>
    </div>

    <!-- Statistics Cards - FIXED 2x2 Layout -->
    <div class="row">
        <!-- Baris Pertama -->
        <div class="col-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pemilih</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $totalPemilih }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-lg text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Sudah Memilih</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $sudahMemilih }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-lg text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Baris Kedua -->
        <div class="col-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Belum Memilih</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $belumMemilih }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-lg text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Partisipasi</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $persentasePartisipasi }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-lg text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions - FIXED 2x2 Layout -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-light py-2">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-6 mb-2">
                            <a href="{{ route('calon.index') }}" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-users"></i> Kelola Calon
                            </a>
                        </div>
                        <div class="col-6 mb-2">
                            <a href="{{ route('admin.results') }}" class="btn btn-info w-100 py-2">
                                <i class="fas fa-chart-bar"></i> Lihat Hasil
                            </a>
                        </div>
                        <div class="col-6 mb-2">
                            <a href="{{ route('calon.create') }}" class="btn btn-warning w-100 py-2">
                                <i class="fas fa-plus"></i> Tambah Calon
                            </a>
                        </div>
                        <div class="col-6 mb-2">
                            <a href="{{ route('pemilih.index') }}" class="btn btn-success w-100 py-2">
                                <i class="fas fa-user-graduate"></i> Data Pemilih
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Pemilihan -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-light py-2">
                    <h5 class="card-title mb-0">Statistik Pemilihan</h5>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Jumlah</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sudah Memilih</td>
                                    <td>{{ $sudahMemilih }}</td>
                                    <td>{{ $persentasePartisipasi }}%</td>
                                </tr>
                                <tr>
                                    <td>Belum Memilih</td>
                                    <td>{{ $belumMemilih }}</td>
                                    <td>{{ $totalPemilih > 0 ? round(($belumMemilih / $totalPemilih) * 100, 2) : 0 }}%</td>
                                </tr>
                                <tr class="table-primary">
                                    <td><strong>Total</strong></td>
                                    <td><strong>{{ $totalPemilih }}</strong></td>
                                    <td><strong>100%</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    /* Mobile First Approach */
    .container-fluid {
        padding-left: 10px;
        padding-right: 10px;
    }

    .row {
        margin-left: -5px;
        margin-right: -5px;
    }

    .col-6 {
        padding-left: 5px;
        padding-right: 5px;
    }

    /* Cards Optimization */
    .card-body.p-3 {
        padding: 0.75rem !important;
    }

    .h6 {
        font-size: 1rem;
        font-weight: bold;
    }

    .text-xs {
        font-size: 0.7rem;
    }

    .fa-lg {
        font-size: 1.2rem;
    }

    /* Buttons */
    .btn {
        min-height: 44px;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }

    .btn .fas {
        margin-right: 4px;
    }

    /* Table */
    .table-sm {
        font-size: 12px;
    }

    /* Desktop Optimization */
    @media (min-width: 768px) {
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }

        .row {
            margin-left: -10px;
            margin-right: -10px;
        }

        .col-6 {
            padding-left: 10px;
            padding-right: 10px;
        }

        .btn {
            font-size: 14px;
        }

        .table-sm {
            font-size: 14px;
        }

        .h6 {
            font-size: 1.25rem;
        }

        .fa-lg {
            font-size: 1.5rem;
        }
    }

    @media (min-width: 992px) {
        .col-6 {
            flex: 0 0 25%;
            max-width: 25%;
        }
    }
</style>
@endsection
