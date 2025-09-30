<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalonSeeder extends Seeder
{
    public function run(): void
    {
        $calons = [
            [
                'nama_calon' => 'Muhammad Alif',
                'foto' => null,
                'visi' => 'Mewujudkan SMK PGRI 5 Jember sebagai sekolah unggulan yang berprestasi dan berkarakter',
                'misi' => '1. Meningkatkan prestasi akademik dan non-akademik
2. Mengembangkan bakat dan minat siswa
3. Memperkuat karakter religius dan nasionalis
4. Meningkatkan sarana dan prasarana sekolah',
                'jumlah_suara' => 0,
            ],
            [
                'nama_calon' => 'Siti Aisyah',
                'foto' => null,
                'visi' => 'Menjadikan OSIS sebagai wadah kreativitas dan inovasi siswa',
                'misi' => '1. Mengadakan kegiatan ekstrakurikuler yang variatif
2. Meningkatkan kualitas organisasi siswa
3. Membangun hubungan harmonis antar siswa
4. Mengoptimalkan peran OSIS dalam sekolah',
                'jumlah_suara' => 0,
            ],
            [
                'nama_calon' => 'Rizki Ramadhan',
                'foto' => null,
                'visi' => 'Membangun sekolah yang nyaman, kreatif, dan berprestasi',
                'misi' => '1. Menciptakan lingkungan sekolah yang bersih dan nyaman
2. Mengembangkan program entrepreneurship siswa
3. Meningkatkan kegiatan keagamaan
4. Memperkuat hubungan dengan alumni',
                'jumlah_suara' => 0,
            ],
        ];

        DB::table('calons')->insert($calons);
    }
}
