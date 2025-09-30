@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Calon Ketua OSIS</h1>
        <a href="{{ route('calon.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('calon.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_calon" class="form-label">Nama Calon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_calon') is-invalid @enderror"
                                id="nama_calon" name="nama_calon" value="{{ old('nama_calon') }}" required>
                            @error('nama_calon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Calon</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto"
                                name="foto" accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="visi" class="form-label">Visi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('visi') is-invalid @enderror" id="visi" name="visi" rows="4"
                                required>{{ old('visi') }}</textarea>
                            @error('visi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="misi" class="form-label">Misi <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('misi') is-invalid @enderror" id="misi" name="misi" rows="6"
                        required>{{ old('misi') }}</textarea>
                    @error('misi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Gunakan poin-poin untuk misi (contoh: 1. Misi pertama... 2. Misi kedua...)</div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-secondary me-md-2">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
