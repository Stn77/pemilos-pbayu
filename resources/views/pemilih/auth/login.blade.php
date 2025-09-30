@extends('pemilih.layouts.app')

@section('content')
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0"><i class="fas fa-user-graduate"></i> LOGIN PEMILIH</h3>
                    <small class="opacity-75">Sistem Pemilihan Ketua OSIS SMK PGRI 5 Jember</small>
                </div>
                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pemilih.login') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="nisn" class="form-label fw-bold">NISN</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-id-card text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="nisn" name="nisn"
                                    value="{{ old('nisn') }}" required autofocus placeholder="Masukkan NISN">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control border-start-0" id="password" name="password"
                                    required placeholder="Masukkan Password">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold">
                                <i class="fas fa-sign-in-alt"></i> MASUK
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <small class="text-muted">
                            Login sebagai admin?
                            <a href="{{ url('/admin/login') }}" class="text-decoration-none">Klik di sini</a>
                        </small>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Informasi:</strong> Gunakan NISN dan password yang telah diberikan panitia.
                </div>
            </div>
        </div>
    </div>
@endsection
