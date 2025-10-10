<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Calon;
use App\Models\Pemilih;
use App\Models\User;
use App\Models\Voting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    // get result
    public function results()
    {
        $calon = Calon::orderBy('jumlah_suara', 'desc')->get();
        $totalSuara = Voting::count();

        return view('admin.results', compact('calon', 'totalSuara'));
    }

    // get chart data
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

    public function vote(Request $request, Calon $calon)
    {
        $pemilih = Auth::user();

        // Validasi: pastikan pemilih belum memilih
        if ($pemilih->sudah_memilih) {
            return redirect()->route('pemilih.thanks')->with('error', 'Anda sudah melakukan voting.');
        }

        // Simpan voting
        Voting::create([
            'user_id' => $pemilih->id,
            'calon_id' => $calon->id,
            'waktu_voting' => now(),
        ]);

        // Update status pemilih
        User::find($pemilih->id)->update(['sudah_memilih' => true]);

        // Update jumlah suara calon
        $calon->increment('jumlah_suara');

        return redirect()->route('pemilih.thanks')->with('success', 'Terima kasih! Voting Anda telah direkam.');
    }
}
