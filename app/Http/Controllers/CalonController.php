<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use App\Models\Misi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        try {
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

            DB::beginTransaction();

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

            // Insert all misi at once
            Misi::insert($misiData);

            DB::commit();

            return redirect()->route('calon.index')->with('success', 'Data calon berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error storing calon: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data calon.');
        }
    }

    public function show(Calon $calon)
    {
        $calon->with('misi');
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
