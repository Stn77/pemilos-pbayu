@extends('pemilih.layouts.app')

@section('content')
    <div class="container">
        <!-- Tombol Kembali Saja -->
        {{-- <div class="row mt-3">
            <div class="col-12">
                <a href="{{ url('/') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div> --}}

        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4><i class="fas fa-user-shield"></i> Login Pemilih </h4>
                        <small>Sistem Pemilihan OSIS SMK PGRI 5 Jember</small>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="nisn" class="form-label">NISN</label>
                                <input type="nisn" class="form-control" id="nisn" name="nisn"
                                    value="{{ old('nisn') }}" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        <hr>
                        {{-- <div class="text-center">
                            <small>Login sebagai pemilih?
                                <a href="{{ route('pemilih.login') }}">Klik di sini</a>
                            </small>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush

