<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $pemilih = Role::create(['name' => 'pemilih']);

        User::create([
            'name' => 'admin',
            'nisn' => '123',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123'),
        ])->assignRole($admin);

        User::create([
            'name' => 'pemilih',
            'nisn' => '1234567890',
            'email' => '',
            'password' => Hash::make('123')
        ])->assignRole($pemilih);
    }
}
