<?php

namespace App\Http\Controllers;

use App\Models\ShopBundle;
use App\Models\ShopProduct;

class ShopController extends Controller
{
    public function index()
    {
        // Bundles (e.g. Pink set, Green set)
        $bundles = ShopBundle::active()->with(['products' => function ($q) {
            $q->active()->inStock()->orderBy('sort_order');
        }])->get();

        // Standalone products (not part of a bundle)
        $products = ShopProduct::active()
            ->whereNull('bundle_id')
            ->inStock()
            ->orderBy('sort_order')
            ->get();

        $stats = [
            'bundles_count'  => $bundles->count(),
            'products_count' => $products->count(),
        ];

        return view('shop', compact('bundles', 'products', 'stats'));
    }
}
