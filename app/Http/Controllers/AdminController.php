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


}
