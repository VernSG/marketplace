<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the buyer's orders grouped by status.
     */
    public function index(): View
    {
        $orders = Order::with(['shop', 'orderItems.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // Group orders by status
        $ordersByStatus = $orders->groupBy('status');

        // Define status order for display
        $statusOrder = [
            'pending',
            'waiting_verification',
            'processed',
            'shipped',
            'completed',
            'cancelled'
        ];

        return view('buyer.orders.index', compact('ordersByStatus', 'statusOrder'));
    }

    /**
     * Display the specified order with shop's bank information.
     */
    public function show(Order $order): View
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load relationships including shop's bank details
        $order->load(['shop', 'orderItems.product']);

        return view('buyer.orders.show', compact('order'));
    }

    /**
     * Show the form to upload payment proof.
     */
    public function uploadProofForm(Order $order): View
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow upload if order is pending
        if ($order->status !== 'pending') {
            return redirect()->route('buyer.orders.show', $order)
                ->with('error', 'Payment proof can only be uploaded for pending orders.');
        }

        $order->load('shop');

        return view('buyer.orders.upload-proof', compact('order'));
    }

    /**
     * Handle the payment proof upload and update order status.
     */
    public function uploadProof(Request $request, Order $order): RedirectResponse
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow upload if order is pending
        if ($order->status !== 'pending') {
            return redirect()->route('buyer.orders.show', $order)
                ->with('error', 'Payment proof can only be uploaded for pending orders.');
        }

        $validated = $request->validate([
            'payment_proof' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Delete old payment proof if exists
        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        // Upload new payment proof
        $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        // Update order with payment proof and change status
        $order->update([
            'payment_proof' => $paymentProofPath,
            'status' => 'waiting_verification',
        ]);

        return redirect()->route('buyer.orders.show', $order)
            ->with('success', 'Payment proof uploaded successfully! Your order is now waiting for seller verification.');
    }

    /**
     * Mark order as completed (buyer confirmation).
     */
    public function markAsCompleted(Order $order): RedirectResponse
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow completion if order is shipped
        if ($order->status !== 'shipped') {
            return redirect()->route('buyer.orders.show', $order)
                ->with('error', 'Only shipped orders can be marked as completed.');
        }

        // Update order status to completed
        $order->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->route('buyer.orders.show', $order)
            ->with('success', 'Order marked as completed. Thank you for your purchase!');
    }

    /**
     * Display printable receipt for the order.
     */
    public function printReceipt(Order $order): View
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load relationships
        $order->load(['shop', 'orderItems.product', 'user']);

        return view('buyer.orders.print-receipt', compact('order'));
    }
}
