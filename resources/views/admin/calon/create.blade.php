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
                            <textarea class="form-control @error('visi') is-invalid @enderror" id="visi" name="visi" rows="4" id="visi"
                                required>{{ old('visi') }}</textarea>
                            @error('visi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-group row mb-3">
                        <label for="misi1" class="col-sm-2 col-form-label">Misi 1 <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="misi1" placeholder="Misi 1" name="misi_1" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="misi2" class="col-sm-2 col-form-label">Misi 2 <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="misi2" placeholder="Misi 2" name="misi_2" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="misi3" class="col-sm-2 col-form-label">Misi 3 <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="misi3" placeholder="Misi 3" name="misi_3" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="misi4" class="col-sm-2 col-form-label">Misi 4</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="misi4" placeholder="Misi 4" name="misi_4">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="misi5" class="col-sm-2 col-form-label">Misi 5</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="misi5" placeholder="Misi 5" name="misi_5">
                        </div>
                    </div>
                    @error('misi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
