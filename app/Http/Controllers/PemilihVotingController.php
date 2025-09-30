<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use App\Models\Pemilih;
use App\Models\Voting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemilihVotingController extends Controller
{
    public function dashboard()
    {
        $pemilih = Auth::guard('pemilih')->user();
        $calon = Calon::all();

        return view('pemilih.dashboard', compact('pemilih', 'calon'));
    }

    public function profile()
    {
        $pemilih = Auth::guard('pemilih')->user();
        return view('pemilih.profile', compact('pemilih'));
    }

    public function voting()
    {
        $pemilih = Auth::guard('pemilih')->user();

        // Cek apakah sudah memilih menggunakan method yang sudah diperbaiki
        if ($pemilih->sudah_memilih) {
            return redirect()->route('pemilih.thanks');
        }

        $calon = Calon::all();
        return view('pemilih.voting', compact('pemilih', 'calon'));
    }

    public function vote(Request $request, Calon $calon)
    {
        $pemilih = Auth::guard('pemilih')->user();

        // Validasi: pastikan pemilih belum memilih
        if ($pemilih->sudah_memilih) {
            return redirect()->route('pemilih.thanks')->with('error', 'Anda sudah melakukan voting.');
        }

        // Simpan voting
        Voting::create([
            'pemilih_id' => $pemilih->id,
            'calon_id' => $calon->id,
            'waktu_voting' => now(),
        ]);

        // Update status pemilih
       Pemilih::where('id', $pemilih->id)->update(['sudah_memilih' => true]);

        // Update jumlah suara calon
        $calon->increment('jumlah_suara');

        return redirect()->route('pemilih.thanks')->with('success', 'Terima kasih! Voting Anda telah direkam.');
    }

    public function thanks()
    {
        $pemilih = Auth::guard('pemilih')->user();
        return view('pemilih.thanks', compact('pemilih'));
    }
}
