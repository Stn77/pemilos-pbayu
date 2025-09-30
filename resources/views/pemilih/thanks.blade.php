@extends('pemilih.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-success shadow">
                <div class="card-body text-center py-5">
                    <i class="fas fa-check-circle text-success display-1 mb-4"></i>
                    <h2 class="text-success mb-3">Terima Kasih!</h2>
                    <p class="lead mb-4">Anda telah menggunakan hak pilih Anda dalam Pemilihan Ketua OSIS SMK PGRI 5 Jember.
                    </p>

                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-user-graduate"></i> Informasi Pemilih
                            </h5>
                            <p class="mb-1"><strong>Nama:</strong> {{ $pemilih->nama }}</p>
                            <p class="mb-1"><strong>NISN:</strong> {{ $pemilih->nisn }}</p>
                            <p class="mb-0"><strong>Kelas:</strong> {{ $pemilih->kelas }}</p>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong> Hasil pemilihan akan diumumkan setelah proses voting selesai.
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('pemilih.dashboard') }}" class="btn btn-primary me-2">
                            <i class="fas fa-home"></i> Kembali ke Dashboard
                        </a>
                        <a href="{{ route('pemilih.logout') }}" class="btn btn-outline-secondary"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('pemilih.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
