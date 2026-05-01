<?php

namespace App\Console\Commands;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class RunFlashSale extends Command
{
    protected $signature = 'cafe:flash-sale';
    protected $description = 'Apply 20% flash sale discount to the 3 least-sold products for 1 hour';

    public function handle()
    {
        // First, clear any expired flash sales
        Product::where('discount_percentage', '>', 0)
            ->where('discount_expires_at', '<=', now())
            ->update([
                'discount_percentage' => 0,
                'discount_expires_at' => null,
            ]);

        // Check if there's already an active flash sale
        $activeFlashSales = Product::where('discount_percentage', '>', 0)
            ->where('discount_expires_at', '>', now())
            ->count();

        if ($activeFlashSales > 0) {
            $this->info("Flash sale is already active. Skipping.");
            return;
        }

        // Find the 3 least-sold available products in the last 30 days
        $leastSold = Product::where('is_available', true)
            ->withCount(['orderItems as total_sold' => function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('created_at', '>=', now()->subDays(30));
                });
            }])
            ->orderBy('total_sold', 'asc')
            ->limit(3)
            ->get();

        if ($leastSold->isEmpty()) {
            $this->info("No products found for flash sale.");
            return;
        }

        $expiresAt = now()->addHour();

        foreach ($leastSold as $product) {
            $product->update([
                'discount_percentage' => 20,
                'discount_expires_at' => $expiresAt,
            ]);
            $this->info("🔥 Flash Sale: {$product->name} — 20% off until {$expiresAt->format('H:i')}");
        }

        $this->info("Flash sale activated for {$leastSold->count()} products!");
    }
}
