<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            // AdminSeeder::class,
            // PemilihSeeder::class,
            CalonSeeder::class,
            UserSeeder::class,
        ]);
    }
}
