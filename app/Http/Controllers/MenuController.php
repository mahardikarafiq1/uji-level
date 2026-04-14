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
        $products = Product::where('is_available', true)
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                return [
                    'id'          => $product->id,
                    'name'        => $product->name,
                    'price'       => (float) $product->price,
                    'description' => $product->description,
                    'category'    => $product->category,
                    'image_url'   => $product->image_url,
                ];
            });

        return response()->json($products);
    }
}
