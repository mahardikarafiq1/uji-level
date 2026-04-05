<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@felizecafe.com'],
            [
                'name'     => 'Cafe Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Seed sample products
        $products = [
            ['name' => 'Caramel Macchiato', 'price' => 35000, 'description' => 'Sweet caramel with espresso and steamed milk'],
            ['name' => 'Iced Americano',    'price' => 28000, 'description' => 'Bold espresso over ice'],
            ['name' => 'Matcha Latte',      'price' => 32000, 'description' => 'Premium Japanese matcha with steamed milk'],
            ['name' => 'Cappuccino',        'price' => 30000, 'description' => 'Classic espresso with velvety foam'],
            ['name' => 'Croissant',         'price' => 22000, 'description' => 'Buttery, flaky French pastry'],
            ['name' => 'Avocado Toast',     'price' => 45000, 'description' => 'Fresh avocado on sourdough with seasoning'],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['name' => $product['name']], $product);
        }

        // Seed sample seats
        $seats = [
            ['seat_code' => 'A1', 'capacity' => 2, 'position' => 'Window'],
            ['seat_code' => 'A2', 'capacity' => 2, 'position' => 'Window'],
            ['seat_code' => 'B1', 'capacity' => 4, 'position' => 'Indoor'],
            ['seat_code' => 'B2', 'capacity' => 4, 'position' => 'Indoor'],
            ['seat_code' => 'C1', 'capacity' => 6, 'position' => 'Outdoor'],
            ['seat_code' => 'C2', 'capacity' => 6, 'position' => 'Outdoor'],
            ['seat_code' => 'V1', 'capacity' => 8, 'position' => 'VIP Room'],
        ];

        foreach ($seats as $seat) {
            Seat::firstOrCreate(['seat_code' => $seat['seat_code']], $seat);
        }
    }
}
