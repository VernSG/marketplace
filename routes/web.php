<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Buyer\DashboardController as BuyerDashboard;
use App\Http\Controllers\Buyer\OrderController as BuyerOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboard;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// Public Routes - Product Browsing
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/products', [FrontController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [FrontController::class, 'show'])->name('products.show');

// Cart Routes (Authenticated Users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', AdminUserController::class);
});

// Seller Routes
Route::middleware(['auth', 'verified', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerDashboard::class, 'index'])->name('dashboard');
    
    // Product Management
    Route::resource('products', SellerProductController::class);
    
    // Order Management
    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/verify-payment', [SellerOrderController::class, 'verifyPaymentForm'])->name('orders.verify-payment-form');
    Route::post('/orders/{order}/verify-payment', [SellerOrderController::class, 'verifyPayment'])->name('orders.verify-payment');
    Route::post('/orders/{order}/reject-payment', [SellerOrderController::class, 'rejectPayment'])->name('orders.reject-payment');
    Route::post('/orders/{order}/mark-shipped', [SellerOrderController::class, 'markAsShipped'])->name('orders.mark-shipped');
});

// Buyer Routes
Route::middleware(['auth', 'verified', 'role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', [BuyerDashboard::class, 'index'])->name('dashboard');
    
    // Order Management
    Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [BuyerOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/print-receipt', [BuyerOrderController::class, 'printReceipt'])->name('orders.print-receipt');
    Route::get('/orders/{order}/upload-proof', [BuyerOrderController::class, 'uploadProofForm'])->name('orders.upload-proof-form');
    Route::post('/orders/{order}/upload-proof', [BuyerOrderController::class, 'uploadProof'])->name('orders.upload-proof');
    Route::post('/orders/{order}/mark-completed', [BuyerOrderController::class, 'markAsCompleted'])->name('orders.mark-completed');
});

// Shop Routes (Authenticated users without a shop can create one)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/shop/create', [ShopController::class, 'create'])->name('shop.create');
    Route::post('/shop', [ShopController::class, 'store'])->name('shop.store');
    Route::get('/shop/edit', [ShopController::class, 'edit'])->name('shop.edit');
    Route::patch('/shop', [ShopController::class, 'update'])->name('shop.update');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
