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
            'name' => 'panitia',
            'nisn' => '112233',
            'email' => 'panitia@admin.com',
            'password' => Hash::make('123'),
        ])->assignRole($admin);

        // User::create([
        //     'name' => 'anas',
        //     'nisn' => '1234',
        //     'password' => Hash::make('1234')
        // ])->assignRole($pemilih);
        // User::create([
        //     'name' => 'viaz',
        //     'nisn' => '12345',
        //     'password' => Hash::make('12345')
        // ])->assignRole($pemilih);
        // User::create([
        //     'name' => 'indah',
        //     'nisn' => '123456',
        //     'password' => Hash::make('123456')
        // ])->assignRole($pemilih);
    }
}
