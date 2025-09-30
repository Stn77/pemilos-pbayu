@extends('pemilih.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-vote-yea"></i> Pemilihan Ketua OSIS
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian!</strong>
                        <ul class="mb-0 mt-2">
                            <li>Pilihlah calon dengan bijak dan penuh tanggung jawab</li>
                            <li>Anda hanya dapat memilih <strong>satu kali</strong> saja</li>
                            <li>Pilihan Anda tidak dapat diubah setelah submit</li>
                            <li>Pastikan memilih sesuai dengan hati nurani</li>
                        </ul>
                    </div>

                    <div class="row">
                        @foreach ($calon as $c)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card card-calon h-100 border-primary">
                                    <div class="card-header bg-light text-center">
                                        <h5 class="card-title mb-0 text-primary">{{ $c->nama_calon }}</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        @if ($c->foto)
                                            <img src="{{ asset('storage/' . $c->foto) }}" alt="{{ $c->nama_calon }}"
                                                class="rounded-circle mb-3" width="120" height="120"
                                                style="object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                style="width: 120px; height: 120px;">
                                                <i class="fas fa-user fa-2x text-white"></i>
                                            </div>
                                        @endif

                                        <h6 class="text-primary">Visi</h6>
                                        <p class="card-text small">{{ Str::limit($c->visi, 100) }}</p>
                                        <h6 class="text-primary">misi</h6>
                                        @foreach ($c->misi as $misi)
                                        <p class="card-text small">{{ Str::limit($misi->misi, 100) }}</p>

                                        @endforeach

                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                            data-bs-toggle="modal" data-bs-target="#detailModal{{ $c->id }}">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </button>
                                    </div>
                                    <div class="card-footer bg-transparent text-center">
                                        <form action="{{ route('pemilih.vote', $c->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-lg px-4"
                                                onclick="return confirm('Apakah Anda yakin memilih {{ $c->nama_calon }}?')">
                                                <i class="fas fa-check-circle"></i> Pilih
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Detail -->
                            <div class="modal fade" id="detailModal{{ $c->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Profil Calon - {{ $c->nama_calon }}</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    @if ($c->foto)
                                                        <img src="{{ asset('storage/' . $c->foto) }}"
                                                            alt="{{ $c->nama_calon }}"
                                                            class="rounded-circle img-fluid mb-3" style="max-width: 200px;">
                                                    @else
                                                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                            style="width: 200px; height: 200px;">
                                                            <i class="fas fa-user fa-3x text-white"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-8">
                                                    <h5 class="text-primary">Visi</h5>
                                                    <p>{{ $c->visi }}</p>

                                                    <h5 class="text-primary mt-4">Misi</h5>
                                                    @foreach ($c->misi as $misi)

                                                    <div style="white-space: pre-line;">{{ $misi->misi }}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times"></i> Tutup
                                            </button>
                                            <form action="{{ route('pemilih.vote', $c->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success"
                                                    onclick="return confirm('Apakah Anda yakin memilih {{ $c->nama_calon }}?')">
                                                    <i class="fas fa-check-circle"></i> Pilih Kandidat Ini
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($calon->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum ada calon yang terdaftar</h4>
                            <p class="text-muted">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto close modal after form submit
        document.addEventListener('DOMContentLoaded', function() {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function() {
                    const forms = this.querySelectorAll('form');
                    forms.forEach(form => {
                        form.reset();
                    });
                });
            });
        });
    </script>
@endpush
