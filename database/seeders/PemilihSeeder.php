<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PemilihSeeder extends Seeder
{
    public function run(): void
    {
        $pemilihs = [
            [
                'nisn' => '1234567890',
                'nama' => 'Ahmad Rizki',
                'kelas' => 'X TKJ 1',
                'password' => Hash::make('password123'),
                'sudah_memilih' => false,
            ],
            [
                'nisn' => '1234567891',
                'nama' => 'Siti Nurhaliza',
                'kelas' => 'X TKJ 2',
                'password' => Hash::make('password123'),
                'sudah_memilih' => false,
            ],
            [
                'nisn' => '1234567892',
                'nama' => 'Budi Santoso',
                'kelas' => 'XI MM 1',
                'password' => Hash::make('password123'),
                'sudah_memilih' => false,
            ],
            [
                'nisn' => '1234567893',
                'nama' => 'Dewi Lestari',
                'kelas' => 'XI MM 2',
                'password' => Hash::make('password123'),
                'sudah_memilih' => false,
            ],
            [
                'nisn' => '1234567894',
                'nama' => 'Rizki Pratama',
                'kelas' => 'XII RPL 1',
                'password' => Hash::make('password123'),
                'sudah_memilih' => false,
            ],
        ];

        DB::table('pemilihs')->insert($pemilihs);
    }
}
