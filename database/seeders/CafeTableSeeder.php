<?php

namespace Database\Seeders;

use App\Models\CafeTable;
use Illuminate\Database\Seeder;

class CafeTableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['name' => 'Meja 1', 'capacity' => 2, 'status' => 'available'],
            ['name' => 'Meja 2', 'capacity' => 2, 'status' => 'available'],
            ['name' => 'Meja 3', 'capacity' => 4, 'status' => 'available'],
            ['name' => 'Meja 4', 'capacity' => 4, 'status' => 'available'],
            ['name' => 'Meja 5', 'capacity' => 6, 'status' => 'available'],
            ['name' => 'Meja 6', 'capacity' => 6, 'status' => 'available'],
            ['name' => 'Meja VIP 1', 'capacity' => 8, 'status' => 'available'],
            ['name' => 'Meja VIP 2', 'capacity' => 10, 'status' => 'available'],
            ['name' => 'Sofa Corner', 'capacity' => 3, 'status' => 'available'],
            ['name' => 'Bar Seat', 'capacity' => 1, 'status' => 'available'],
        ];

        foreach ($tables as $table) {
            CafeTable::firstOrCreate(['name' => $table['name']], $table);
        }
    }
}
