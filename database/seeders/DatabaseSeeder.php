<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            VillesSeeder::class,
            PassagersSeeder::class,
            ConducteursSeeder::class,
            AdminsSeeder::class,
        ]);
    }
}