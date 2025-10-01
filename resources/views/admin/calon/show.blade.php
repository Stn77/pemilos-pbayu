@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Calon - {{ $calon->nama_calon }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('calon.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('calon.edit', $calon->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('calon.destroy', $calon->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus calon ini?')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="card-title mb-0">Foto Calon</h5>
                </div>
                <div class="card-body text-center">
                    @if ($calon->foto)
                        <img src="{{ asset('storage/' . $calon->foto) }}" alt="{{ $calon->nama_calon }}"
                            class="img-fluid rounded" style="max-height: 300px;">
                    @else
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                            style="height: 200px;">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header bg-info text-white text-center">
                    <h5 class="card-title mb-0">Statistik</h5>
                </div>
                <div class="card-body text-center">
                    <div class="h1 text-primary">{{ $calon->jumlah_suara }}</div>
                    <div class="text-muted">Total Suara</div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Profil Calon</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-primary">Nama Calon</h6>
                        <p class="fs-5">{{ $calon->nama_calon }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-primary">Visi</h6>
                        <div class="border rounded p-3 bg-light">
                            {{ $calon->visi }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-primary">Misi</h6>
                        <div class="border rounded p-3 bg-light" style="white-space: pre-line;">
                            @foreach ($calon->misi as $misi)
                            {{$misi->misi}}
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-primary">Informasi Tambahan</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Dibuat Pada</th>
                                <td>{{ $calon->created_at->format('d F Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diupdate Pada</th>
                                <td>{{ $calon->updated_at->format('d F Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
