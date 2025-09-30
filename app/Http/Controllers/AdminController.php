<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use App\Models\Pemilih;
use App\Models\Voting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPemilih = Pemilih::count();
        $totalCalon = Calon::count();
        $sudahMemilih = Pemilih::where('sudah_memilih', true)->count();
        $belumMemilih = Pemilih::where('sudah_memilih', false)->count();

        $persentasePartisipasi = $totalPemilih > 0 ? round(($sudahMemilih / $totalPemilih) * 100, 2) : 0;

        return view('admin.dashboard', compact(
            'totalPemilih',
            'totalCalon',
            'sudahMemilih',
            'belumMemilih',
            'persentasePartisipasi'
        ));
    }

    public function results()
    {
        $calon = Calon::orderBy('jumlah_suara', 'desc')->get();
        $totalSuara = Voting::count();

        return view('admin.results', compact('calon', 'totalSuara'));
    }

    public function getResultsData()
    {
        $calon = Calon::orderBy('jumlah_suara', 'desc')->get();
        $totalSuara = Voting::count();

        $labels = [];
        $data = [];
        $colors = [];

        $colorPalette = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69'];

        foreach ($calon as $index => $c) {
            $labels[] = $c->nama_calon;
            $data[] = $c->jumlah_suara;
            $colors[] = $colorPalette[$index % count($colorPalette)];
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors,
            'totalSuara' => $totalSuara,
            'calon' => $calon
        ]);
    }
}
