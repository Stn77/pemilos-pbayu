@extends('pemilih.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-user-circle"></i> Profil Saya
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 120px; height: 120px;">
                                <i class="fas fa-user-graduate fa-3x text-white"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%"><i class="fas fa-id-card"></i> NISN</th>
                                        <td>{{ $pemilih['nisn'] }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-user"></i> Nama Lengkap</th>
                                        <td>{{ $pemilih['nama'] }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-users"></i> Kelas</th>
                                        <td>{{ $pemilih['kelas'] }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-vote-yea"></i> Status Voting</th>
                                        <td>
                                            @if ($pemilih['sudah_memilih'])
                                                <span class="badge bg-success fs-6">
                                                    <i class="fas fa-check-circle"></i> Sudah Memilih
                                                </span>
                                            @else
                                                <span class="badge bg-warning fs-6">
                                                    <i class="fas fa-clock"></i> Belum Memilih
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if (!$pemilih['sudah_memilih'])
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle"></i>
                            <strong>Informasi:</strong> Anda belum menggunakan hak pilih.
                            Silakan gunakan hak pilih Anda dengan memilih calon ketua OSIS.
                        </div>
                    @else
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle"></i>
                            <strong>Terima kasih!</strong> Anda telah menggunakan hak pilih dalam pemilihan ini.
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('pemilih.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-home"></i> Kembali ke Dashboard
                        </a>
                        @if (!$pemilih['sudah_memilih'])
                            <a href="{{ route('pemilih.voting') }}" class="btn btn-success">
                                <i class="fas fa-vote-yea"></i> Mulai Voting
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
