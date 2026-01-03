<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ShopController extends Controller
{
    /**
     * Show the form for creating a new shop.
     */
    public function create(): View
    {
        // Check if user already has a shop
        if (Auth::user()->shop) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'You already have a shop.');
        }

        return view('shops.create');
    }

    /**
     * Store a newly created shop in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if user already has a shop
        if (Auth::user()->shop) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'You already have a shop.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:500'],
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_account_number' => ['required', 'string', 'max:255'],
            'bank_account_holder' => ['required', 'string', 'max:255'],
        ]);

        // Generate unique slug from name
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;

        // Ensure slug is unique
        while (Shop::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Create the shop
        $shop = Shop::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'address' => $validated['address'] ?? null,
            'bank_name' => $validated['bank_name'],
            'bank_account_number' => $validated['bank_account_number'],
            'bank_account_holder' => $validated['bank_account_holder'],
            'is_active' => true,
            'rating' => 0,
        ]);

        // Update user role to seller
        $user = Auth::user();
        $user->role = 'seller';
        $user->save();

        return redirect()->route('seller.dashboard')
            ->with('success', 'Shop created successfully! Welcome to your seller dashboard.');
    }

    /**
     * Show the form for editing the shop.
     */
    public function edit(): View
    {
        $shop = Auth::user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create')
                ->with('error', 'You need to create a shop first.');
        }

        return view('shops.edit', compact('shop'));
    }

    /**
     * Update the shop in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $shop = Auth::user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create')
                ->with('error', 'You need to create a shop first.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:500'],
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_account_number' => ['required', 'string', 'max:255'],
            'bank_account_holder' => ['required', 'string', 'max:255'],
        ]);

        // Generate unique slug from name if name changed
        if ($validated['name'] !== $shop->name) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;

            // Ensure slug is unique
            while (Shop::where('slug', $slug)->where('id', '!=', $shop->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $shop->slug = $slug;
        }

        // Update the shop
        $shop->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'address' => $validated['address'] ?? null,
            'bank_name' => $validated['bank_name'],
            'bank_account_number' => $validated['bank_account_number'],
            'bank_account_holder' => $validated['bank_account_holder'],
        ]);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Shop updated successfully.');
    }
}
