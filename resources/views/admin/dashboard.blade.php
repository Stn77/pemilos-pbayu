@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Admin</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pemilih</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPemilih }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Sudah Memilih</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sudahMemilih }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Belum Memilih</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $belumMemilih }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Partisipasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $persentasePartisipasi }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('calon.index') }}" class="btn btn-primary w-100">
                                <i class="fas fa-users"></i> Kelola Calon
                            </a>
                        </div>
                        {{-- <div class="col-md-3 mb-3">
                        <a href="{{ route('pemilih.index') }}" class="btn btn-success w-100">
                            <i class="fas fa-user-graduate"></i> Kelola Pemilih
                        </a>
                    </div> --}}
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.results') }}" class="btn btn-info w-100">
                                <i class="fas fa-chart-bar"></i> Lihat Hasil
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('calon.create') }}" class="btn btn-warning w-100">
                                <i class="fas fa-plus"></i> Tambah Calon
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Statistik Pemilihan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
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
@endsection
