<?php

namespace App\Http\Controllers;

use App\Models\Pemilih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class PemilihController extends Controller
{
    public function index()
    {
        $pemilih = Pemilih::orderBy('kelas')->orderBy('nama')->get();
        return view('admin.pemilih.index', compact('pemilih'));
    }

    public function create()
    {
        return view('admin.pemilih.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|unique:pemilihs,nisn',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'password' => 'required|string|min:6',
        ]);

        Pemilih::create([
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('pemilih.index')->with('success', 'Data pemilih berhasil ditambahkan.');
    }

    public function show(Pemilih $pemilih)
    {
        return view('admin.pemilih.show', compact('pemilih'));
    }

    public function edit(Pemilih $pemilih)
    {
        return view('admin.pemilih.edit', compact('pemilih'));
    }

    public function update(Request $request, Pemilih $pemilih)
    {
        $request->validate([
            'nisn' => 'required|string|unique:pemilihs,nisn,' . $pemilih->id,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $pemilih->update($data);

        return redirect()->route('pemilih.index')->with('success', 'Data pemilih berhasil diperbarui.');
    }

    public function destroy(Pemilih $pemilih)
    {
        $pemilih->delete();
        return redirect()->route('pemilih.index')->with('success', 'Data pemilih berhasil dihapus.');
    }

    public function resetStatus()
    {
        Pemilih::query()->update(['sudah_memilih' => false]);
        return redirect()->route('pemilih.index')->with('success', 'Status voting semua pemilih telah direset.');
    }

    public function getPemilih(Request $request)
    {
        $data = Pemilih::query();

        if($request->status) {
            if($request->status === 'memilih') $data->where('sudah_memilih', true);
            else $data->where('sudah_memilih', false);
        }

        if($request->kelas) {
            $data->where('kelas', 'LIKE', '%'.$request->kelas.'%');
        }

        return DataTables::of($data->get())
            ->addIndexColumn()
            ->make(true);
    }
}
