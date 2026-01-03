<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Show the checkout form.
     */
    public function index(): View
    {
        $cartItems = CartItem::with(['product.shop', 'product.category'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Group items by shop for display
        $itemsByShop = $cartItems->groupBy(function ($item) {
            return $item->product->shop_id;
        });

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'itemsByShop', 'total'));
    }

    /**
     * Process the checkout and create orders.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'shipping_address' => ['required', 'string', 'max:500'],
            'shipping_courier' => ['required', 'string', 'max:255'],
            'shipping_cost' => ['required', 'numeric', 'min:0'],
            'payment_proof' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        try {
            DB::beginTransaction();

            // Get all cart items for the current user
            $cartItems = CartItem::with(['product.shop'])
                ->where('user_id', Auth::id())
                ->get();

            if ($cartItems->isEmpty()) {
                DB::rollBack();
                return redirect()->route('cart.index')
                    ->with('error', 'Your cart is empty.');
            }

            // Group cart items by shop_id
            $itemsByShop = $cartItems->groupBy(function ($item) {
                return $item->product->shop_id;
            });

            $createdOrders = [];

            // Loop through each shop group
            foreach ($itemsByShop as $shopId => $items) {
                // Validate stock availability for all items
                foreach ($items as $item) {
                    if ($item->product->stock < $item->quantity) {
                        DB::rollBack();
                        return redirect()->route('cart.index')
                            ->with('error', "Insufficient stock for {$item->product->name}. Please update your cart.");
                    }
                }

                // Calculate total for this order
                $orderTotal = $items->sum(function ($item) {
                    return $item->product->price * $item->quantity;
                });

                // Add shipping cost to the total
                $orderTotal += $validated['shipping_cost'];

                // Handle payment proof upload
                $paymentProofUrl = null;
                if ($request->hasFile('payment_proof')) {
                    $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
                    $paymentProofUrl = $paymentProofPath;
                }

                // Generate unique invoice number
                $invoiceNumber = $this->generateInvoiceNumber();

                // Create the Order
                $order = Order::create([
                    'invoice_number' => $invoiceNumber,
                    'user_id' => Auth::id(),
                    'shop_id' => $shopId,
                    'shipping_address' => $validated['shipping_address'],
                    'shipping_courier' => $validated['shipping_courier'],
                    'shipping_cost' => $validated['shipping_cost'],
                    'total_amount' => $orderTotal,
                    'payment_method' => 'bank_transfer',
                    'payment_proof' => $paymentProofUrl,
                    'status' => 'waiting_verification',
                ]);

                // Create OrderItems for this order
                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price_at_purchase' => $item->product->price,
                    ]);
                }

                $createdOrders[] = $order;
            }

            // Clear the user's cart
            CartItem::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('buyer.orders.index')
                ->with('success', 'Orders placed successfully! Waiting for seller verification.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('cart.index')
                ->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }

    /**
     * Generate a unique invoice number.
     * Format: INV/YYYYMMDD/USER/XXX
     */
    private function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');
        $userId = Auth::id();
        
        // Get the count of orders today for this user
        $todayOrderCount = Order::where('user_id', $userId)
            ->whereDate('created_at', now()->toDateString())
            ->count();

        $sequence = str_pad($todayOrderCount + 1, 3, '0', STR_PAD_LEFT);

        return "INV/{$date}/USER{$userId}/{$sequence}";
    }
}
