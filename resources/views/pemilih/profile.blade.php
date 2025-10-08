@extends('pemilih.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6"> {{-- Breakpoint yang lebih responsive --}}
            <div class="card shadow">
                <div class="card-header bg-primary text-white py-3"> {{-- Padding vertikal konsisten --}}
                    <h4 class="card-title mb-0 text-center text-md-start"> {{-- Responsive text alignment --}}
                        <i class="fas fa-user-circle me-2"></i> Profil Saya
                    </h4>
                </div>
                <div class="card-body p-3 p-md-4"> {{-- Padding berbeda mobile/desktop --}}
                    {{-- Profile Section --}}
                    <div class="row align-items-center">
                        {{-- Profile Image - Stack vertically on mobile --}}
                        <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                            <div class="bg-primary rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                style="width: 100px; height: 100px;"> {{-- Size lebih kecil di mobile --}}
                                <i class="fas fa-user-graduate fa-2x text-white"></i> {{-- Icon size responsive --}}
                            </div>
                            {{-- Nama tampil di bawah foto di mobile --}}
                            <h5 class="mt-2 d-block d-md-none fw-bold text-primary">
                                {{ $pemilih['nama'] }}
                            </h5>
                        </div>

                        {{-- Profile Details --}}
                        <div class="col-12 col-md-8">
                            {{-- Sembunyikan nama di desktop (sudah ada di table) --}}
                            <h5 class="d-none d-md-block mb-3 fw-bold text-primary">
                                {{ $pemilih['nama'] }}
                            </h5>

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <th width="35%" class="bg-light">
                                                <i class="fas fa-id-card me-2"></i>NISN
                                            </th>
                                            <td>{{ $pemilih['nisn'] }}</td>
                                        </tr>
                                        {{-- Sembunyikan nama di table untuk mobile --}}
                                        <tr class="d-none d-md-table-row">
                                            <th class="bg-light">
                                                <i class="fas fa-user me-2"></i>Nama Lengkap
                                            </th>
                                            <td>{{ $pemilih['nama'] }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">
                                                <i class="fas fa-users me-2"></i>Kelas
                                            </th>
                                            <td>{{ $pemilih['kelas'] }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">
                                                <i class="fas fa-vote-yea me-2"></i>Status Voting
                                            </th>
                                            <td>
                                                @if ($pemilih['sudah_memilih'])
                                                    <span class="badge bg-success fs-6 d-inline-flex align-items-center">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        <span class="d-none d-sm-inline">Sudah Memilih</span>
                                                        <span class="d-inline d-sm-none">Sudah</span>
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning text-dark fs-6 d-inline-flex align-items-center">
                                                        <i class="fas fa-clock me-1"></i>
                                                        <span class="d-none d-sm-inline">Belum Memilih</span>
                                                        <span class="d-inline d-sm-none">Belum</span>
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Alert Information --}}
                    @if (!$pemilih['sudah_memilih'])
                        <div class="alert alert-info mt-3 mt-md-4">
                            <div class="d-flex">
                                <i class="fas fa-info-circle me-2 mt-1 flex-shrink-0"></i>
                                <div>
                                    <strong>Informasi:</strong> Anda belum menggunakan hak pilih.
                                    Silakan gunakan hak pilih Anda dengan memilih calon ketua OSIS.
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-success mt-3 mt-md-4">
                            <div class="d-flex">
                                <i class="fas fa-check-circle me-2 mt-1 flex-shrink-0"></i>
                                <div>
                                    <strong>Terima kasih!</strong> Anda telah menggunakan hak pilih dalam pemilihan ini.
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="text-center mt-4">
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                            <a href="{{ route('pemilih.dashboard') }}" class="btn btn-primary flex-fill flex-sm-grow-0">
                                <i class="fas fa-home me-1"></i>
                                <span class="d-none d-sm-inline">Kembali ke Dashboard</span>
                                <span class="d-inline d-sm-none">Dashboard</span>
                            </a>
                            @if (!$pemilih['sudah_memilih'])
                                <a href="{{ route('pemilih.voting') }}" class="btn btn-success flex-fill flex-sm-grow-0">
                                    <i class="fas fa-vote-yea me-1"></i>
                                    <span class="d-none d-sm-inline">Mulai Voting</span>
                                    <span class="d-inline d-sm-none">Voting</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
