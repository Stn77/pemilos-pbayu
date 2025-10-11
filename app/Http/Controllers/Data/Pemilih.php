<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Importir\Siswa;
use App\Jobs\ImportPemilih;
use App\Models\Calon;
use App\Models\Pemilih as ModelsPemilih;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class Pemilih extends Controller
{
    protected $excelImportService;
    public function __construct(Siswa $excelImportService)
    {
        $this->excelImportService = $excelImportService;
    }

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
        $data = User::role('pemilih');

        if ($request->status) {
            if ($request->status === 'memilih') {
                $data->where('sudah_memilih', true);
            } else {
                $data->where('sudah_memilih', false);
            }
        }

        if ($request->kelas) {
            $data->where('kelas', 'LIKE', '%' . $request->kelas . '%');
        }

        return DataTables::of($data->select(['name', 'nisn', 'kelas', 'sudah_memilih',])->get())
            ->addIndexColumn()
            ->editColumn('kelas', function ($row) {
                return strtoupper($row->kelas);
            })
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

    public function datapemilih()
    {
        return view('admin.pemilih.index');
    }

    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240' // max 10MB
        ]);

        try {
            // Validasi file
            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240' // max 10MB
            ]);

            // Upload file
            $file = $request->file('excel_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('imports', $fileName, 'local');
            $fullPath = storage_path('app/' . $filePath);

            // Import data
            $result = $this->excelImportService->importSiswa(Storage::path($filePath));

            // Hapus file setelah import
            Storage::disk('local')->delete($filePath);

            if ($result['success']) {
                $message = "Import berhasil! {$result['success_count']} user berhasil diimpor";

                if ($result['error_count'] > 0) {
                    $message .= ", {$result['error_count']} baris gagal diimpor.";
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => [
                        'total_processed' => $result['total_processed'],
                        'success_count' => $result['success_count'],
                        'error_count' => $result['error_count'],
                        'errors' => $result['errors']
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                    'errors' => []
                ], 400);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi file gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'errors' => []
            ], 500);
        }
    }
}
