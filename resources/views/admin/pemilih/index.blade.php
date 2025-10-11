@extends('layouts.admin')

@section('content')
@push('style')

<style>
    .drag-drop-area {
        border: 2px dashed #cbd5e0;
        border-radius: 8px;
        padding: 2rem 1rem;
        text-align: center;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        min-height: 180px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .drag-drop-area:hover {
        border-color: #007bff;
        background-color: #e6f3ff;
    }

    .drag-drop-area.drag-over {
        border-color: #007bff;
        background-color: #e6f3ff;
        border-style: solid;
        transform: scale(1.02);
    }

    .drag-drop-area.has-file {
        border-color: #28a745;
        background-color: #d4edda;
    }

    .file-input-hidden {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .upload-icon {
        font-size: 2.5rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .drag-over .upload-icon {
        color: #007bff;
        animation: bounce 0.6s ease-in-out;
    }

    .has-file .upload-icon {
        color: #28a745;
    }

    @keyframes bounce {
        0%, 20%, 60%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        80% {
            transform: translateY(-5px);
        }
    }

    .file-info {
        display: none;
        background: white;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        margin-top: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .file-info.show {
        display: block;
    }

    .remove-file {
        color: #dc3545;
        cursor: pointer;
        float: right;
        font-size: 1.2rem;
    }

    .remove-file:hover {
        color: #a71d2a;
    }

    .upload-text {
        font-size: 1rem;
        color: #495057;
        margin: 0.5rem 0;
    }

    .upload-subtext {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .progress {
        display: none;
        margin-top: 1rem;
    }

    .form-import-excel,
    #desktopTabContent {
        width: 100%;
    }

    .submit-multi-user {
        gap: 1rem;
    }

    .top {
        display: flex;
        gap: 20px;
        padding: 20px;
    }

    .foto-profile-c {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 3px solid #dee2e6;
    }

    .foto-profile-c img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .data-inti {
        flex: 1;
    }

    .daftar-kelas {
        margin: 0 20px 20px;
    }

    /* Mobile Table Styles */
    .mobile-table {
        display: none;
    }

    .mobile-card {
        margin-bottom: 15px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
    }

    .mobile-card-header {
        background-color: #f8f9fa;
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
        font-weight: 600;
    }

    .mobile-card-body {
        padding: 15px;
    }

    .mobile-card-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        padding-bottom: 8px;
        border-bottom: 1px solid #f1f1f1;
    }

    .mobile-card-row:last-child {
        margin-bottom: 0;
        border-bottom: none;
    }

    .mobile-card-label {
        font-weight: 600;
        color: #495057;
    }

    .mobile-card-value {
        color: #6c757d;
    }

    /* Responsive styles */
    @media (max-width: 1220px) {
        .top {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .foto-profile-c {
            width: 180px;
            height: 180px;
        }

        .data-inti {
            width: 100%;
        }
    }

    @media (max-width: 991px) {
        .drag-drop-area {
            padding: 1.5rem 1rem;
            min-height: 150px;
        }

        .upload-icon {
            font-size: 2rem;
        }

        .upload-text {
            font-size: 0.9rem;
        }

        .upload-subtext {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 768px) {
        .modal-dialog {
            margin: 10px;
        }

        .foto-profile-c {
            width: 150px;
            height: 150px;
        }

        .top {
            padding: 15px;
        }

        .daftar-kelas {
            margin: 0 10px 15px;
            padding: 15px !important;
        }

        /* Show mobile table, hide desktop table */
        .desktop-table {
            display: none;
        }

        .mobile-table {
            display: block;
        }

        .filter-container {
            flex-direction: column;
            gap: 10px;
        }

        .filter-container .form-group {
            width: 100%;
            margin: 5px 0;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
        }

        .filter-buttons .btn {
            flex: 1;
        }
    }

    @media (max-width: 576px) {
        .foto-profile-c {
            width: 120px;
            height: 120px;
        }

        .top {
            padding: 10px;
        }

        .drag-drop-area {
            padding: 1rem 0.5rem;
            min-height: 120px;
        }

        .upload-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .upload-text {
            font-size: 0.85rem;
        }

        .upload-subtext {
            font-size: 0.75rem;
        }

        .modal-dialog {
            margin: 5px;
        }

        .modal-content {
            padding: 10px;
        }

        .btn-toolbar .btn {
            font-size: 0.85rem;
            padding: 8px 12px;
        }
    }
</style>
@endpush
<div class="container-fluid py-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Pemilih Ketua OSIS</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="form-group mb-3">
                <button data-bs-toggle="modal" data-bs-target="#addmodal" class="btn btn-primary">
                    <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Tambah Data</span>
                </button>
            </div>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow">
        <div class="card-body p-0">
            <!-- Desktop Table -->
            <div class="p-4 table-responsive desktop-table">
                <div class="d-flex col filter-container">
                    <div class="form-group mb-3 mx-2 flex-fill">
                        <select class="form-select" name="kelas" id="kelas">
                            <option value="">Pilih Kelas</option>
                            <option value="X MP 1">X MP 1</option>
                            <option value="X MP 2">X MP 2</option>
                            <option value="X MP 3">X MP 3</option>
                            <option value="X BD 1">X BD 1</option>
                            <option value="X BD 2">X BD 2</option>
                            <option value="X AK 1">X AK 1</option>
                            <option value="X AK 2">X AK 2</option>
                            <option value="X PPLG">X PPLG</option>
                            <option value="X DKV">X DKV</option>
                            <option value="X TSM 1">X TSM 1</option>
                            <option value="X TSM 2">X TSM 2</option>
                            <option value="X TSM 3">X TSM 3</option>

                            <option value="XI MP 1">XI MP 1</option>
                            <option value="XI MP 2">XI MP 2</option>
                            <option value="XI MP 3">XI MP 3</option>
                            <option value="XI BD 1">XI BD 1</option>
                            <option value="XI BD 2">XI BD 2</option>
                            <option value="XI AK 1">XI AK 1</option>
                            <option value="XI AK 2">XI AK 2</option>
                            <option value="XI PPLG">XI PPLG</option>
                            <option value="XI DKV">XI DKV</option>
                            <option value="XI TSM 1">XI TSM 1</option>
                            <option value="XI TSM 2">XI TSM 2</option>
                            <option value="XI TSM 3">XI TSM 3</option>

                            <option value="XII MP 1">XII MP 1</option>
                            <option value="XII MP 2">XII MP 2</option>
                            <option value="XII MP 3">XII MP 3</option>
                            <option value="XII BD 1">XII BD 1</option>
                            <option value="XII BD 2">XII BD 2</option>
                            <option value="XII AK 1">XII AK 1</option>
                            <option value="XII AK 2">XII AK 2</option>
                            <option value="XII PPLG">XII PPLG</option>
                            <option value="XII DKV">XII DKV</option>
                            <option value="XII TSM 1">XII TSM 1</option>
                            <option value="XII TSM 2">XII TSM 2</option>
                        </select>
                    </div>
                    <div class="form-group mb-3 mx-2 flex-fill">
                        <select class="form-select" name="status" id="status">
                            <option value="">Status</option>
                            <option value="memilih">Memilih</option>
                            <option value="belum-memilih">Belum Memilih</option>
                        </select>
                    </div>
                    <div class="form-group mb-3 mx-2 filter-buttons">
                        <button class="btn btn-danger" id="filter">
                            <i class="fa-solid fa-filter"></i> <span class="d-none d-md-inline">Filter</span>
                        </button>
                        <button class="btn btn-success" id="reset">
                            <i class="fa-solid fa-rotate"></i> <span class="d-none d-md-inline">Reset</span>
                        </button>
                    </div>
                </div>
                <table class="table mt-2 table-striped table-bordered" id="pesertaTable">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan diisi oleh DataTables -->
                    </tbody>
                </table>
            </div>

            <!-- Mobile Table -->
            <div class="p-3 mobile-table">
                <div class="filter-container">
                    <div class="form-group mb-3">
                        <select class="form-select" name="kelas_mobile" id="kelas_mobile">
                            <option value="">Pilih Kelas</option>
                            <option value="X MP 1">X MP 1</option>
                            <option value="X MP 2">X MP 2</option>
                            <option value="X MP 3">X MP 3</option>
                            <option value="X BD 1">X BD 1</option>
                            <option value="X BD 2">X BD 2</option>
                            <option value="X AK 1">X AK 1</option>
                            <option value="X AK 2">X AK 2</option>
                            <option value="X PPLG">X PPLG</option>
                            <option value="X DKV">X DKV</option>
                            <option value="X TSM 1">X TSM 1</option>
                            <option value="X TSM 2">X TSM 2</option>
                            <option value="X TSM 3">X TSM 3</option>

                            <option value="XI MP 1">XI MP 1</option>
                            <option value="XI MP 2">XI MP 2</option>
                            <option value="XI MP 3">XI MP 3</option>
                            <option value="XI BD 1">XI BD 1</option>
                            <option value="XI BD 2">XI BD 2</option>
                            <option value="XI AK 1">XI AK 1</option>
                            <option value="XI AK 2">XI AK 2</option>
                            <option value="XI PPLG">XI PPLG</option>
                            <option value="XI DKV">XI DKV</option>
                            <option value="XI TSM 1">XI TSM 1</option>
                            <option value="XI TSM 2">XI TSM 2</option>
                            <option value="XI TSM 3">XI TSM 3</option>

                            <option value="XII MP 1">XII MP 1</option>
                            <option value="XII MP 2">XII MP 2</option>
                            <option value="XII MP 3">XII MP 3</option>
                            <option value="XII BD 1">XII BD 1</option>
                            <option value="XII BD 2">XII BD 2</option>
                            <option value="XII AK 1">XII AK 1</option>
                            <option value="XII AK 2">XII AK 2</option>
                            <option value="XII PPLG">XII PPLG</option>
                            <option value="XII DKV">XII DKV</option>
                            <option value="XII TSM 1">XII TSM 1</option>
                            <option value="XII TSM 2">XII TSM 2</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <select class="form-select" name="status_mobile" id="status_mobile">
                            <option value="">Status</option>
                            <option value="memilih">Memilih</option>
                            <option value="belum-memilih">Belum Memilih</option>
                        </select>
                    </div>
                    <div class="filter-buttons">
                        <button class="btn btn-danger" id="filter_mobile">
                            <i class="fa-solid fa-filter"></i> Filter
                        </button>
                        <button class="btn btn-success" id="reset_mobile">
                            <i class="fa-solid fa-rotate"></i> Reset
                        </button>
                    </div>
                </div>
                <div id="mobile-table-content" class="mt-3">
                    <!-- Konten mobile akan diisi oleh JavaScript -->
                </div>
            </div>
        </div>
    </div>

    {{-- add modal --}}
    <div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="desktop-container">
                        <div class="desktop-content">
                            <!-- Tab Content -->
                            <div class="tab-content content-area" id="desktopTabContent">
                                <div class="tab-pane fade show active" id="banyak-data-content" role="tabpanel"
                                    aria-labelledby="banyak-data-tab">
                                    <form action="" class="form-import-excel" method="POST"
                                        enctype="multipart/form-data" id="upload-form">
                                        @csrf

                                        <div class="mb-4">
                                            <div class="drag-drop-area" id="drag-drop-area">
                                                <input type="file" class="file-input-hidden" id="excel_file"
                                                    name="excel_file" accept=".xlsx,.xls,.csv" required>

                                                <div class="upload-content">
                                                    <div class="upload-icon">
                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                    </div>
                                                    <div class="upload-text">
                                                        <strong>Drag & Drop file Excel di sini</strong>
                                                    </div>
                                                    <div class="upload-subtext">
                                                        atau <span style="color: #007bff; font-weight: 500;">klik untuk
                                                            browse</span>
                                                    </div>
                                                    <div class="upload-subtext mt-2">
                                                        <small>Format: .xlsx, .xls, .csv (Max: 10MB)</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="file-info" id="file-info">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="fas fa-file-excel text-success me-2"></i>
                                                        <span id="file-name"></span>
                                                        <small class="text-muted ms-2">(<span
                                                                id="file-size"></span>)</small>
                                                    </div>
                                                    <span class="remove-file" id="remove-file">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="progress" id="upload-progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                    role="progressbar" style="width: 0%"></div>
                                            </div>
                                        </div>
                                        <div class="d-flex submit-multi-user">
                                            <button type="submit" class="btn btn-primary btn-lg flex-fill"
                                                id="submit-btn" disabled>
                                                <i class="fas fa-upload me-2"></i>Import Data Siswa
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(() => {
        // Inisialisasi DataTable untuk desktop
        let pesertaTable = $("#pesertaTable").DataTable({
            processing: true,
            pageLength: 50,
            serverSide: true,
            autoFill: false,
            ajax: {
                url: "{{route('get.pemilih')}}",
                data: function(d){
                    d.kelas = $('#kelas').val()
                    d.status = $('#status').val()
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    title: 'No',
                    orderable: false,
                },
                {data: 'nisn', title: 'NISN'},
                {data: 'name', title: 'Nama'},
                {data: 'kelas', title: 'Kelas'},
                {
                    data: 'sudah_memilih',
                    title: 'Status',
                    searchable: false,
                    render: function(data, type, row){
                        if(row.sudah_memilih){
                            return `
                            <span class="badge bg-success">Memilih</span>
                            `
                        }else{
                            return `
                            <span class="badge bg-danger">Belum</span>
                            `
                        }
                    }
                }
            ]
        });

        // Fungsi untuk memuat data mobile
        function loadMobileData() {
            const kelas = $('#kelas_mobile').val();
            const status = $('#status_mobile').val();

            $.ajax({
                url: "{{route('get.pemilih')}}",
                data: {
                    kelas: kelas,
                    status: status,
                    draw: 1,
                    start: 0,
                    length: 50
                },
                success: function(response) {
                    renderMobileTable(response.data);
                }
            });
        }

        // Fungsi untuk merender tabel mobile
        function renderMobileTable(data) {
            let html = '';

            if (data && data.length > 0) {
                data.forEach((item, index) => {
                    html += `
                    <div class="mobile-card">
                        <div class="mobile-card-header">
                            ${item.nama}
                        </div>
                        <div class="mobile-card-body">
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">NISN:</span>
                                <span class="mobile-card-value">${item.nisn}</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Kelas:</span>
                                <span class="mobile-card-value">${item.kelas}</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Status:</span>
                                <span class="mobile-card-value">
                                    ${item.sudah_memilih
                                        ? '<span class="badge bg-success">Memilih</span>'
                                        : '<span class="badge bg-danger">Belum</span>'}
                                </span>
                            </div>
                        </div>
                    </div>
                    `;
                });
            } else {
                html = '<p class="text-center py-3">Tidak ada data yang ditemukan</p>';
            }

            $('#mobile-table-content').html(html);
        }

        // Event handler untuk filter desktop
        $("#filter").on('click', () => {
            pesertaTable.draw();
        });

        $("#reset").on('click', () => {
            $('#kelas').val('');
            $('#status').val('');
            pesertaTable.draw();
        });

        // Event handler untuk filter mobile
        $("#filter_mobile").on('click', () => {
            loadMobileData();
        });

        $("#reset_mobile").on('click', () => {
            $('#kelas_mobile').val('');
            $('#status_mobile').val('');
            loadMobileData();
        });

        // Muat data mobile pertama kali
        loadMobileData();

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dragDropArea = document.getElementById('drag-drop-area');
        const fileInput = document.getElementById('excel_file');
        const fileInfo = document.getElementById('file-info');
        const fileName = document.getElementById('file-name');
        const fileSize = document.getElementById('file-size');
        const removeFileBtn = document.getElementById('remove-file');
        const submitBtn = document.getElementById('submit-btn');
        const uploadForm = document.getElementById('upload-form');
        const uploadProgress = document.getElementById('upload-progress');
        const progressBar = uploadProgress.querySelector('.progress-bar');

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dragDropArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dragDropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dragDropArea.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dragDropArea.addEventListener('drop', handleDrop, false);
        dragDropArea.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                handleFiles(e.target.files);
            }
        });

        // Remove file
        removeFileBtn.addEventListener('click', function() {
            removeFile();
        });

        // AJAX FORM SUBMISSION
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent normal form submission

            if (fileInput.files.length === 0) {
                showNotifCreate('Pilih file Excel terlebih dahulu', 'error');
                return;
            }

            uploadFileAjax();
        });

        function uploadFileAjax() {
            const formData = new FormData();
            formData.append('excel_file', fileInput.files[0]);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            // Show progress and disable button
            showProgress();
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Importing...';

            // Show processing notification
            showNotifCreate('Sedang memproses file Excel...', 'info');

            // AJAX Request
            fetch('{{route('pemilih.import')}}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                // Success handling
                hideProgress();
                resetForm();

                // Show success notification
                showNotifCreate(data.message, 'success');

                // Show detailed errors if any
                if (data.data.errors && data.data.errors.length > 0) {
                    setTimeout(() => {
                        let errorMessage = 'Detail Error:\n';
                        data.data.errors.slice(0, 5).forEach(error => {
                            errorMessage += '• ' + error + '\n';
                        });
                        if (data.data.errors.length > 5) {
                            errorMessage += `... dan ${data.data.errors.length - 5} error lainnya`;
                        }
                        showNotifCreate(errorMessage, 'warning', 3000);
                    }, 1000);
                }

                // RELOAD DATATABLE & Hide modal
                $('#addModal').modal('hide');
                $('#data-guru').DataTable().ajax.reload(null, false);
            })
            .catch(error => {
                // Error handling
                hideProgress();
                resetSubmitButton();

                let errorMessage = 'Terjadi kesalahan saat import';
                if (error.message) {
                    errorMessage = error.message;
                } else if (error.errors) {
                    // Validation errors
                    const firstError = Object.values(error.errors)[0];
                    if (Array.isArray(firstError)) {
                        errorMessage = firstError[0];
                    }
                }

                showNotifCreate(errorMessage, 'error');
                console.error('Import Error:', error);
            });
        }

        function showProgress() {
            uploadProgress.style.display = 'block';
            let progress = 0;

            const interval = setInterval(() => {
                progress += Math.random() * 10;
                if (progress > 90) progress = 90;
                progressBar.style.width = progress + '%';

                if (progress >= 90) {
                    clearInterval(interval);
                }
            }, 200);

            // Store interval untuk cleanup nanti
            uploadProgress.progressInterval = interval;
        }

        function hideProgress() {
            // Complete progress bar
            progressBar.style.width = '100%';
            progressBar.classList.remove('progress-bar-animated');

            // Clear interval if exists
            if (uploadProgress.progressInterval) {
                clearInterval(uploadProgress.progressInterval);
            }

            // Hide after animation
            setTimeout(() => {
                uploadProgress.style.display = 'none';
                progressBar.style.width = '0%';
                progressBar.classList.add('progress-bar-animated');
            }, 1000);
        }

        function resetForm() {
            fileInput.value = '';
            removeFile();
            resetSubmitButton();
        }

        function resetSubmitButton() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-upload me-2"></i>Import Data Siswa';
        }

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight() {
            dragDropArea.classList.add('drag-over');
        }

        function unhighlight() {
            dragDropArea.classList.remove('drag-over');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];

                // Validate file type
                const allowedTypes = [
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-excel',
                    'text/csv'
                ];

                if (!allowedTypes.includes(file.type) && !file.name.match(/\.(xlsx|xls|csv)$/i)) {
                    showNotifCreate('Format file tidak didukung. Gunakan .xlsx, .xls, atau .csv', 'error');
                    return;
                }

                // Validate file size (10MB)
                if (file.size > 10 * 1024 * 1024) {
                    showNotifCreate('Ukuran file terlalu besar. Maksimal 10MB', 'error');
                    return;
                }

                // Update file input
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;

                // Show file info
                showFileInfo(file);
                showNotifCreate(`File "${file.name}" siap untuk diupload`, 'success');
            }
        }

        function showFileInfo(file) {
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileInfo.classList.add('show');
            dragDropArea.classList.add('has-file');
            submitBtn.disabled = false;

            // Update drag drop area content
            const uploadContent = dragDropArea.querySelector('.upload-content');
            uploadContent.innerHTML = `
                <div class="upload-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="upload-text text-success">
                    <strong>File siap untuk diupload!</strong>
                </div>
                <div class="upload-subtext">
                    Klik "Import Data Siswa" untuk memulai proses import
                </div>
            `;
        }

        function removeFile() {
            fileInput.value = '';
            fileInfo.classList.remove('show');
            dragDropArea.classList.remove('has-file');
            submitBtn.disabled = true;

            // Reset drag drop area content
            const uploadContent = dragDropArea.querySelector('.upload-content');
            uploadContent.innerHTML = `
                <div class="upload-icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div class="upload-text">
                    <strong>Drag & Drop file Excel di sini</strong>
                </div>
                <div class="upload-subtext">
                    atau <span style="color: #007bff; font-weight: 500;">klik untuk browse</span>
                </div>
                <div class="upload-subtext mt-2">
                    <small>Format: .xlsx, .xls, .csv (Max: 10MB)</small>
                </div>
            `;
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    });
</script>
@endpush
@endsection
