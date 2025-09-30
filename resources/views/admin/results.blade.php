@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hasil Pemilihan Real-time</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button id="refreshBtn" class="btn btn-primary">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">Grafik Hasil Pemilihan</h6>
                    <span id="lastUpdate" class="small">Memuat data...</span>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="resultsChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">Statistik Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="h1 font-weight-bold text-gray-800 mb-0" id="totalSuara">0</div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Suara Masuk
                        </div>
                    </div>
                    <hr>
                    <div id="quickStats">
                        <!-- Quick stats will be loaded here -->
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">Ranking Calon</h6>
                </div>
                <div class="card-body">
                    <div id="rankingList">
                        <!-- Ranking list will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h6 class="m-0 font-weight-bold">Detail Hasil Per Calon</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="resultsTable">
                        <!-- Results table will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let resultsChart;

        // Function to load results data
        function loadResultsData() {
            fetch('{{ route('admin.results.data') }}')
                .then(response => response.json())
                .then(data => {
                    updateChart(data);
                    updateQuickStats(data);
                    updateRankingList(data);
                    updateResultsTable(data);
                    updateLastUpdate();
                })
                .catch(error => {
                    console.error('Error loading results:', error);
                });
        }

        // Function to update chart
        function updateChart(data) {
            const ctx = document.getElementById('resultsChart').getContext('2d');

            if (resultsChart) {
                resultsChart.destroy();
            }

            resultsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Jumlah Suara',
                        data: data.data,
                        backgroundColor: data.colors,
                        borderColor: data.colors.map(color => color.replace('0.8', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Suara: ${context.parsed.y}`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Function to update quick stats
        function updateQuickStats(data) {
            document.getElementById('totalSuara').textContent = data.totalSuara;

            let quickStatsHTML = '';
            data.calon.forEach((calon, index) => {
                const percentage = data.totalSuara > 0 ? ((calon.jumlah_suara / data.totalSuara) * 100).toFixed(1) :
                    0;
                quickStatsHTML += `
            <div class="mb-3">
                <div class="small font-weight-bold text-primary">${calon.nama_calon}</div>
                <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                        <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">${calon.jumlah_suara} suara</div>
                    </div>
                    <div class="col">
                        <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-primary" role="progressbar"
                                 style="width: ${percentage}%" aria-valuenow="${percentage}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="small text-muted">${percentage}%</div>
                    </div>
                </div>
            </div>
        `;
            });

            document.getElementById('quickStats').innerHTML = quickStatsHTML;
        }

        // Function to update ranking list
        function updateRankingList(data) {
            let rankingHTML = '';
            data.calon.forEach((calon, index) => {
                const rankClass = index === 0 ? 'text-warning' : 'text-secondary';
                const icon = index === 0 ? 'fa-trophy' : 'fa-medal';

                rankingHTML += `
            <div class="d-flex align-items-center mb-3">
                <div class="mr-3">
                    <div class="icon-circle ${rankClass}">
                        <i class="fas ${icon}"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="small font-weight-bold">${calon.nama_calon}</div>
                    <div class="text-xs text-muted">${calon.jumlah_suara} suara</div>
                </div>
                <div class="text-right">
                    <span class="badge bg-primary">#${index + 1}</span>
                </div>
            </div>
        `;
            });

            document.getElementById('rankingList').innerHTML = rankingHTML;
        }

        // Function to update results table
        function updateResultsTable(data) {
            let tableHTML = `
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nama Calon</th>
                    <th>Jumlah Suara</th>
                    <th>Persentase</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
    `;

            data.calon.forEach((calon, index) => {
                const percentage = data.totalSuara > 0 ? ((calon.jumlah_suara / data.totalSuara) * 100).toFixed(1) :
                    0;
                const isLeading = index === 0 && calon.jumlah_suara > 0;

                tableHTML += `
            <tr ${isLeading ? 'class="table-success"' : ''}>
                <td>${index + 1}</td>
                <td>${calon.nama_calon}</td>
                <td>
                    <span class="badge bg-primary fs-6">${calon.jumlah_suara}</span>
                </td>
                <td>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-primary" role="progressbar"
                             style="width: ${percentage}%" aria-valuenow="${percentage}"
                             aria-valuemin="0" aria-valuemax="100">
                            ${percentage}%
                        </div>
                    </div>
                </td>
                <td>
                    ${isLeading ? '<span class="badge bg-success"><i class="fas fa-crown"></i> Peringkat 1</span>' : ''}
                </td>
            </tr>
        `;
            });

            tableHTML += `
            </tbody>
        </table>
    `;

            document.getElementById('resultsTable').innerHTML = tableHTML;
        }

        // Function to update last update time
        function updateLastUpdate() {
            const now = new Date();
            document.getElementById('lastUpdate').textContent = `Terakhir update: ${now.toLocaleTimeString()}`;
        }

        // Auto refresh every 10 seconds
        setInterval(loadResultsData, 10000);

        // Manual refresh button
        document.getElementById('refreshBtn').addEventListener('click', loadResultsData);

        // Load data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadResultsData();
        });
    </script>

    <style>
        .icon-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f8f9fa;
            border: 2px solid #e3e6f0;
        }

        .text-warning .icon-circle {
            border-color: #f6c23e;
            background-color: #fdf6e3;
        }

        .chart-bar {
            position: relative;
            height: 300px;
        }
    </style>
@endpush
