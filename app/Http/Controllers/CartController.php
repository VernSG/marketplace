<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the user's cart.
     */
    public function index(): View
    {
        $cartItems = CartItem::with(['product.shop', 'product.category'])
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function addToCart(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check if product is active
        if (!$product->is_active || !$product->shop->is_active) {
            return back()->with('error', 'This product is not available.');
        }

        // Check if product has enough stock
        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock available.');
        }

        // Check if item already exists in cart
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($cartItem) {
            // Item exists, increment quantity
            $newQuantity = $cartItem->quantity + $validated['quantity'];

            // Check if new quantity exceeds stock
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Cannot add more. Stock limit reached.');
            }

            $cartItem->update(['quantity' => $newQuantity]);
            $message = 'Cart updated successfully!';
        } else {
            // Create new cart item
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
            ]);
            $message = 'Product added to cart successfully!';
        }

        return back()->with('success', $message);
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        // Check stock availability
        if ($cartItem->product->stock < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock available.');
        }

        $cartItem->update($validated);

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy(CartItem $cartItem): RedirectResponse
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart!');
    }
}
