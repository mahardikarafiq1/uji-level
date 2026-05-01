<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');

        $query = Product::where('is_available', true)->orderBy('name');

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        $products = $query->get();

        $categories = [
            'all'      => 'Semua',
            'coffee'   => '☕ Coffee',
            'beverage' => '🧃 Minuman',
            'food'     => '🍔 Makanan',
            'dessert'  => '🍰 Dessert',
        ];

        return view('menu', compact('products', 'categories', 'category'));
    }

    /**
     * Show detailed product page for public user.
     */
    public function show(Product $product)
    {
        return view('product-detail', compact('product'));
    }

    /**
     * API endpoint for AJAX product loading.
     */
    public function products(Request $request)
    {
        $products = cache()->remember('products_api', 60, function () {
            return Product::where('is_available', true)
                ->orderBy('name')
                ->get();
        });

        $mapped = $products->map(function ($product) {
            return [
                'id'                  => $product->id,
                'name'                => $product->name,
                'price'               => (float) $product->price,
                'effective_price'     => (float) $product->effective_price,
                'description'         => $product->description,
                'category'            => $product->category,
                'image_url'           => $product->image_url,
                'is_flash_sale'       => $product->isOnFlashSale(),
                'discount_percentage' => $product->isOnFlashSale() ? $product->discount_percentage : 0,
                'discount_expires_at' => $product->isOnFlashSale() ? $product->discount_expires_at->toIso8601String() : null,
            ];
        });

        return response()->json($mapped);
    }
}
