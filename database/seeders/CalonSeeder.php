<?php

namespace Database\Seeders;

use App\Models\Calon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalonSeeder extends Seeder
{
    public function run(): void
    {
       $calon1 = Calon::create([
            'nama_calon' => 'BAYU',
            'foto' => 'b.jpg',
            'visi' => 'Terwujudnya pemilihan ketua osis yang jujur, adil, dan transparan serta dapat membawa perubahan yang lebih baik untuk sekolah.',
            'jumlah_suara' => 0
        ]);
        DB::table('misis')->insert([
            ['misi' => 'Meningkatkan kualitas pendidikan di sekolah.', 'calon_id' => $calon1->id],
            ['misi' => 'Menyediakan fasilitas belajar yang lebih baik.', 'calon_id' => $calon1->id],
            ['misi' => 'Mengadakan kegiatan ekstrakurikuler yang bervariasi.', 'calon_id' => $calon1->id],
            ['misi' => 'Meningkatkan komunikasi antara siswa dan guru.', 'calon_id' => $calon1->id],
            ['misi' => 'Menciptakan lingkungan sekolah yang bersih dan nyaman.', 'calon_id' => $calon1->id],
        ]);

        $calon2 = Calon::create([
            'nama_calon' => 'RIZKI',
            'foto' => 'r.jpg',
            'visi' => 'Mewujudkan pemilihan ketua osis yang demokratis, transparan, dan dapat membawa perubahan positif bagi sekolah.',
            'jumlah_suara' => 0
        ]);
        DB::table('misis')->insert([
            ['misi' => 'Meningkatkan kualitas pendidikan di sekolah.', 'calon_id' => $calon2->id],
            ['misi' => 'Menyediakan fasilitas belajar yang lebih baik.', 'calon_id' => $calon2->id],
            ['misi' => 'Mengadakan kegiatan ekstrakurikuler yang bervariasi.', 'calon_id' => $calon2->id],
            ['misi' => 'Meningkatkan komunikasi antara siswa dan guru.', 'calon_id' => $calon2->id],
            ['misi' => 'Menciptakan lingkungan sekolah yang bersih dan nyaman.', 'calon_id' => $calon2->id],
       ]);
    }
}
