<?php

namespace App\Jobs;

use App\Importir\Siswa;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportPemilih implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    /**
     * Create a new job instance.
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(Siswa $excelImportService): void
    {
        try {
            Log::info('Memulai job import siswa dari file: ' . $this->filePath);

            $result = $excelImportService->importSiswa(Storage::path($this->filePath));

            Log::info('Job import selesai', [
                'success_count' => $result['success_count'] ?? 0,
                'error_count' => $result['error_count'] ?? 0
            ]);

            // hapus file setelah selesai
            Storage::disk('local')->delete($this->filePath);
        } catch (Exception $e) {
            Log::error('Job ImportSiswa gagal: ' . $e->getMessage());
        }
    }
}
