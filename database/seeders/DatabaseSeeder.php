<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Products::create([
            'name' => 'Prodcut-1',
            'credit' => 5,
            'price' => 9.99,
            'is_status' => 1
        ]);

        Products::create([
            'name' => 'Prodcut-2',
            'credit' => 10,
            'price' => 19.99,
            'is_status' => 1
        ]);

        Products::create([
            'name' => 'Prodcut-3',
            'credit' => 15,
            'price' => 29.99,
            'is_status' => 1
        ]);

    }
}
