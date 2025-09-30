<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CalonController extends Controller
{
    public function index()
    {
        $calon = Calon::all();
        return view('admin.calon.index', compact('calon'));
    }

    public function create()
    {
        return view('admin.calon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_calon' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'visi' => 'required|string',
            'misi' => 'required|string',
        ]);

        $data = $request->only(['nama_calon', 'visi', 'misi']);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('calon', 'public');
            $data['foto'] = $fotoPath;
        }

        Calon::create($data);

        return redirect()->route('calon.index')->with('success', 'Data calon berhasil ditambahkan.');
    }

    public function show(Calon $calon)
    {
        return view('admin.calon.show', compact('calon'));
    }

    public function edit(Calon $calon)
    {
        return view('admin.calon.edit', compact('calon'));
    }

    public function update(Request $request, Calon $calon)
    {
        $request->validate([
            'nama_calon' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'visi' => 'required|string',
            'misi' => 'required|string',
        ]);

        $data = $request->only(['nama_calon', 'visi', 'misi']);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($calon->foto) {
                Storage::disk('public')->delete($calon->foto);
            }

            $fotoPath = $request->file('foto')->store('calon', 'public');
            $data['foto'] = $fotoPath;
        }

        $calon->update($data);

        return redirect()->route('calon.index')->with('success', 'Data calon berhasil diperbarui.');
    }

    public function destroy(Calon $calon)
    {
        // Hapus foto jika ada
        if ($calon->foto) {
            Storage::disk('public')->delete($calon->foto);
        }

        $calon->delete();

        return redirect()->route('calon.index')->with('success', 'Data calon berhasil dihapus.');
    }
}
