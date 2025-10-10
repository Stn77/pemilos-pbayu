<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Calon;
use App\Models\Pemilih as ModelsPemilih;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class Pemilih extends Controller
{
    public function index()
    {
        $pemilih = Auth::user();
        $calon = Calon::all();
        return view('pemilih.dashboard', compact('pemilih', 'calon'));
    }

    public function dashboard()
    {
        $pemilih = Auth::user();
        $calon = Calon::all();

        return view('pemilih.dashboard', compact('pemilih', 'calon'));
    }

    public function profile()
    {
        $pemilih = Auth::user();
        return view('pemilih.profile', compact('pemilih'));
    }

    public function thanks()
    {
        $pemilih = Auth::user();
        return view('pemilih.thanks', compact('pemilih'));
    }

    public function getPemilih(Request $request)
    {
        $data = ModelsPemilih::query();

        if ($request->status) {
            if ($request->status === 'memilih') $data->where('sudah_memilih', true);
            else $data->where('sudah_memilih', false);
        }

        if ($request->kelas) {
            $data->where('kelas', 'LIKE', '%' . $request->kelas . '%');
        }

        return DataTables::of($data->get())
            ->addIndexColumn()
            ->make(true);
    }

    public function memilih() {}

    public function voting()
    {
        $pemilih = User::find(Auth::user()->id);
        // dd($pemilih);

        // Cek apakah sudah memilih menggunakan method yang sudah diperbaiki
        if ($pemilih->sudah_memilih) {
            return redirect()->route('pemilih.thanks');
        }

        $calon = Calon::with('misi')->get();
        return view('pemilih.voting', compact('pemilih', 'calon'));
    }
}
