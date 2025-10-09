@extends('pemilih.layouts.app')

@section('content')
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-5 col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0"><i class="fas fa-user"></i> LOGIN PEMILIH</h4>
                        <small>Sistem Pemilihan Ketua OSIS SMK PGRI 5 Jember</small>
                    </div>
                    <div class="card-body p-3">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-3">
                                <i class="fas fa-exclamation-triangle"></i>
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('pemilih.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="nisn" class="form-label">NISN</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <input type="text" class="form-control" id="nisn" name="nisn"
                                        value="{{ old('nisn') }}" required autofocus placeholder="Masukkan NISN">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="password" name="password"
                                        required placeholder="Masukkan Password">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2  justify-content-center">
                                MASUK <i class="fas fa-sign-in-alt"></i>
                            </button>
                        </form>

                        {{-- <div class="text-center mt-3">
                            <small class="text-muted">
                                Login sebagai admin?<a href="{{ url('/admin/login') }}" class="justify-content-center">Klik di sini</a>
                            </small>
                        </div> --}}
                    </div>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle"></i>
                    <strong>Informasi:</strong> Gunakan NISN dan password yang telah diberikan panitia.
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 576px) {
            .container {
                padding: 10px;
            }
            .card-body {
                padding: 20px !important;
            }
            .btn {
                padding: 12px;
                font-size: 16px;
            }
            input, select, textarea {
                font-size: 16px !important;
            }
        }

        .btn, .input-group-text, a {
            min-height: 44px;
            display: flex;
            align-items: center;
        }

        .input-group-text {
            min-width: 50px;
            justify-content: center;
        }
    </style>
@endsection
