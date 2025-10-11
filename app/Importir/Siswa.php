<?php

namespace App\Importir;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Siswa
{
    function importSiswa($filePath)
    {
        try{
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Remove header row
            $header = array_shift($rows);

            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            DB::beginTransaction();

            foreach($rows as $index => $row){
                $rowNumber = $index + 2;

                try{
                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    // Validasi data
                    if (count($row) < 4) {
                        $errors[] = "Baris {$rowNumber}: Data tidak lengkap";
                        $errorCount++;
                        continue;
                    }

                    $nisn = trim($row[0]);
                    $namaLengkap = trim($row[1]);
                    $kelas = trim($row[2]);
                    $password = trim($row[3]);

                    // Validasi field tidak boleh kosong
                    if (empty($namaLengkap) || empty($password) || empty($nisn) || empty($kelas)) {
                        $errors[] = "Baris {$rowNumber}: Ada field yang kosong";
                        $errorCount++;
                        continue;
                    }

                    // Password minimal 6 karakter
                    if(strlen($password) < 4){
                        $errors[] = "Baris {$rowNumber}: Password minimal 6 karakter";
                        $errorCount++;
                        continue;
                    }

                    // NISN harus angka dan minimal 5 digit
                    if(empty($nisn)){
                        $errors[] = "Baris {$rowNumber}: NISN harus berupa angka dan minimal 5 digit";
                        $errorCount++;
                        continue;
                    }

                    // nama lengkap minimal 3 karakter
                    if(empty($namaLengkap) || strlen($namaLengkap) < 3){
                        $errors[] = "Baris {$rowNumber}: Nama lengkap minimal 3 karakter";
                        $errorCount++;
                        continue;
                    }

                    // Insert user
                    User::create([
                        'name' => $namaLengkap,
                        'nisn' => substr($nisn, 0, 5),
                        'password' => $password,
                        'kelas' => strtolower($kelas)
                    ])->assignRole('pemilih');

                    $successCount++;

                }catch(Exception $e){
                    $errors[] = "Baris {$rowNumber}: Error - " . $e->getMessage();
                    $errorCount++;
                    Log::error("Import error on row {$rowNumber}: " . $e->getMessage());
                    Log::error($errors);
                }
            }

            DB::commit();

            return [
                'success' => true,
                'total_processed' => $successCount + $errorCount,
                'success_count' => $successCount,
                'error_count' => $errorCount,
                'errors' => $errors
            ];
        }catch(Exception $e){
            DB::rollback();
            Log::error('Excel import failed: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Gagal mengimpor file: ' . $e->getMessage(),
                'errors' => []
            ];
        }
    }
}
