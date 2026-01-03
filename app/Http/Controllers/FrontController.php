<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontController extends Controller
{
    /**
     * Display all active products with pagination.
     */
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'shop'])
            ->where('is_active', true)
            ->whereHas('shop', function ($q) {
                $q->where('is_active', true);
            });

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search by name if provided
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);

        return view('front.products.index', compact('products'));
    }

    /**
     * Display product details.
     */
    public function show(Product $product): View
    {
        // Ensure product is active
        if (!$product->is_active || !$product->shop->is_active) {
            abort(404, 'Product not found or unavailable.');
        }

        // Load relationships
        $product->load(['category', 'shop']);

        // Get related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->whereHas('shop', function ($q) {
                $q->where('is_active', true);
            })
            ->limit(4)
            ->get();

        return view('front.products.show', compact('product', 'relatedProducts'));
    }
}
