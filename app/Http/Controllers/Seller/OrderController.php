<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of orders for the seller's shop.
     */
    public function index(Request $request): View
    {
        $shop = Auth::user()->shop;

        if (!$shop) {
            abort(403, 'You do not have a shop.');
        }

        $query = Order::with(['user', 'orderItems.product'])
            ->where('shop_id', $shop->id);

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        // Get status counts for filter buttons
        $statusCounts = [
            'all' => Order::where('shop_id', $shop->id)->count(),
            'pending' => Order::where('shop_id', $shop->id)->where('status', 'pending')->count(),
            'waiting_verification' => Order::where('shop_id', $shop->id)->where('status', 'waiting_verification')->count(),
            'processed' => Order::where('shop_id', $shop->id)->where('status', 'processed')->count(),
            'shipped' => Order::where('shop_id', $shop->id)->where('status', 'shipped')->count(),
            'completed' => Order::where('shop_id', $shop->id)->where('status', 'completed')->count(),
            'cancelled' => Order::where('shop_id', $shop->id)->where('status', 'cancelled')->count(),
        ];

        return view('seller.orders.index', compact('orders', 'statusCounts'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): View
    {
        // Ensure the order belongs to the seller's shop
        if ($order->shop_id !== Auth::user()->shop->id) {
            abort(403, 'Unauthorized action.');
        }

        $order->load(['user', 'orderItems.product']);

        return view('seller.orders.show', compact('order'));
    }

    /**
     * Show the payment verification page.
     */
    public function verifyPaymentForm(Order $order): View
    {
        // Ensure the order belongs to the seller's shop
        if ($order->shop_id !== Auth::user()->shop->id) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow verification for orders with status 'waiting_verification'
        if ($order->status !== 'waiting_verification') {
            return redirect()->route('seller.orders.show', $order)
                ->with('error', 'Only orders waiting for verification can be verified.');
        }

        $order->load(['user', 'orderItems.product']);

        return view('seller.orders.verify-payment', compact('order'));
    }

    /**
     * Accept payment and update order status to 'processed'.
     */
    public function verifyPayment(Request $request, Order $order): RedirectResponse
    {
        // Ensure the order belongs to the seller's shop
        if ($order->shop_id !== Auth::user()->shop->id) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow verification for orders with status 'waiting_verification'
        if ($order->status !== 'waiting_verification') {
            return redirect()->route('seller.orders.show', $order)
                ->with('error', 'Only orders waiting for verification can be verified.');
        }

        try {
            DB::beginTransaction();

            // Decrease product stock for each order item
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                
                // Check if product has enough stock
                if ($product->stock < $item->quantity) {
                    DB::rollBack();
                    return redirect()->route('seller.orders.verify-payment-form', $order)
                        ->with('error', "Insufficient stock for {$product->name}. Current stock: {$product->stock}, Required: {$item->quantity}");
                }

                // Decrease stock
                $product->decrement('stock', $item->quantity);
            }

            // Update order status to 'processed'
            $order->update([
                'status' => 'processed'
            ]);

            DB::commit();

            return redirect()->route('seller.orders.show', $order)
                ->with('success', 'Payment verified successfully! Order is now being processed.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('seller.orders.verify-payment-form', $order)
                ->with('error', 'An error occurred while verifying payment. Please try again.');
        }
    }

    /**
     * Reject payment and update order status to 'cancelled'.
     */
    public function rejectPayment(Request $request, Order $order): RedirectResponse
    {
        // Ensure the order belongs to the seller's shop
        if ($order->shop_id !== Auth::user()->shop->id) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow rejection for orders with status 'waiting_verification'
        if ($order->status !== 'waiting_verification') {
            return redirect()->route('seller.orders.show', $order)
                ->with('error', 'Only orders waiting for verification can be rejected.');
        }

        $validated = $request->validate([
            'cancellation_note' => ['required', 'string', 'max:500'],
        ]);

        // Update order status to 'cancelled' with reason
        $order->update([
            'status' => 'cancelled',
            'cancellation_note' => $validated['cancellation_note'],
        ]);

        return redirect()->route('seller.orders.show', $order)
            ->with('success', 'Order has been cancelled and the buyer will be notified.');
    }

    /**
     * Update order status to 'shipped'.
     */
    public function markAsShipped(Order $order): RedirectResponse
    {
        // Ensure the order belongs to the seller's shop
        if ($order->shop_id !== Auth::user()->shop->id) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow shipping orders with status 'processed'
        if ($order->status !== 'processed') {
            return redirect()->route('seller.orders.show', $order)
                ->with('error', 'Only processed orders can be marked as shipped.');
        }

        $order->update([
            'status' => 'shipped'
        ]);

        return redirect()->route('seller.orders.show', $order)
            ->with('success', 'Order marked as shipped!');
    }
}
