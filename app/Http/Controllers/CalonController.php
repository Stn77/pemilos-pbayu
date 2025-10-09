<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use App\Models\Misi;
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
            'misi_1' => 'required|string',
            'misi_2' => 'required|string',
            'misi_3' => 'required|string',
            'misi_4' => 'nullable|string',
            'misi_5' => 'nullable|string',
        ]);

        // Handle foto upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('calon', 'public');
        }

        // Create calon
        $calon = Calon::create([
            'nama_calon' => $request->nama_calon,
            'foto' => $fotoPath,
            'visi' => $request->visi,
        ]);

        // Create misi records
        $misiData = [
            ['calon_id' => $calon->id, 'misi' => $request->misi_1],
            ['calon_id' => $calon->id, 'misi' => $request->misi_2],
            ['calon_id' => $calon->id, 'misi' => $request->misi_3],
        ];

        // Add optional misi if they exist
        if ($request->filled('misi_4')) {
            $misiData[] = ['calon_id' => $calon->id, 'misi' => $request->misi_4];
        }

        if ($request->filled('misi_5')) {
            $misiData[] = ['calon_id' => $calon->id, 'misi' => $request->misi_5];
        }

        Misi::insert($misiData);

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
            'misi_1' => 'required|string|max:255',
            'misi_2' => 'required|string|max:255',
            'misi_3' => 'required|string|max:255',
            'misi_4' => 'nullable|string|max:255',
            'misi_5' => 'nullable|string|max:255',
        ]);

        // Update data calon
        $dataCalon = [
            'nama_calon' => $request->nama_calon,
            'visi' => $request->visi,
        ];

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($calon->foto) {
                Storage::disk('public')->delete($calon->foto);
            }

            $fotoPath = $request->file('foto')->store('calon', 'public');
            $dataCalon['foto'] = $fotoPath;
        }

        $calon->update($dataCalon);

        // Update misi
        $misiData = [
            ['misi' => $request->misi_1],
            ['misi' => $request->misi_2],
            ['misi' => $request->misi_3],
        ];

        if ($request->filled('misi_4')) {
            $misiData[] = ['misi' => $request->misi_4];
        }

        if ($request->filled('misi_5')) {
            $misiData[] = ['misi' => $request->misi_5];
        }

        // Hapus misi lama dan buat yang baru
        $calon->misi()->delete();
        $calon->misi()->createMany($misiData);

        return redirect()->route('calon.index')
            ->with('success', 'Data calon berhasil diperbarui');
    }

    /**
     * Hapus data calon - VERSI SIMPLE
     */
    public function destroy($id)
    {
        try {
            $calon = Calon::findOrFail($id);

            // Hapus foto jika ada
            if ($calon->foto) {
                Storage::disk('public')->delete($calon->foto);
            }

            // Hapus data misi terkait
            $calon->misi()->delete();

            // Hapus calon
            $calon->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data calon berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
