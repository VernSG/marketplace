<x-app-layout>
    <!-- Page Header -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Keranjang Belanja</h1>
                    <p class="text-neutral-600">{{ $cartItems->count() }} produk dalam keranjang</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($cartItems->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cartItems as $item)
                            <div class="card">
                                <div class="flex gap-4">
                                    <!-- Product Image -->
                                    <a href="{{ route('products.show', $item->product->slug) }}" class="shrink-0">
                                        <div class="w-24 h-24 rounded-lg overflow-hidden bg-neutral-100">
                                            @if($item->product->image_url)
                                                <img src="{{ Storage::url($item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-neutral-100 to-neutral-200">
                                                    <svg class="w-8 h-8 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </a>

                                    <!-- Product Details -->
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('products.show', $item->product->slug) }}" class="block group">
                                            <h3 class="font-semibold text-neutral-900 group-hover:text-primary-600 transition-colors line-clamp-2 mb-1">
                                                {{ $item->product->name }}
                                            </h3>
                                        </a>
                                        <p class="text-sm text-neutral-500 mb-2">{{ $item->product->shop->name }}</p>
                                        <p class="text-lg font-bold text-primary-600">
                                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                        </p>
                                        
                                        <!-- Stock Warning -->
                                        @if($item->quantity > $item->product->stock)
                                            <p class="text-xs text-red-600 mt-2 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                                Stok tersisa {{ $item->product->stock }} unit
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Quantity & Actions -->
                                    <div class="flex flex-col items-end gap-3">
                                        <!-- Quantity Update -->
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <label class="text-sm text-neutral-600">Qty:</label>
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" 
                                                class="input-field w-20 py-1.5 px-3 text-sm"
                                                onchange="this.form.submit()">
                                        </form>

                                        <!-- Subtotal -->
                                        <p class="text-xl font-bold text-neutral-900">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </p>

                                        <!-- Remove Button -->
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium flex items-center gap-1" onclick="return confirm('Hapus produk dari keranjang?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="card sticky top-24">
                            <h2 class="text-xl font-bold text-neutral-900 mb-6">Ringkasan Belanja</h2>
                            
                            <div class="space-y-3 mb-6 pb-6 border-b border-neutral-200">
                                <div class="flex justify-between text-neutral-600">
                                    <span>Total Produk ({{ $cartItems->sum('quantity') }} item)</span>
                                    <span class="font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center mb-6">
                                <span class="text-lg font-semibold text-neutral-900">Total Harga</span>
                                <span class="text-2xl font-bold text-primary-600">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="space-y-3">
                                <a href="{{ route('checkout.index') }}" class="btn-primary w-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Lanjut ke Pembayaran
                                </a>
                                <a href="{{ route('products.index') }}" class="btn-secondary w-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Lanjut Belanja
                                </a>
                            </div>

                            <!-- Trust Badge -->
                            <div class="mt-6 pt-6 border-t border-neutral-200">
                                <div class="flex items-center gap-3 text-sm text-neutral-600">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    <span>Pembayaran aman dan terpercaya</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart State -->
                <div class="card text-center py-16">
                    <div class="flex flex-col items-center gap-6">
                        <div class="w-24 h-24 bg-neutral-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-neutral-900 mb-2">Keranjang Belanja Kosong</h3>
                            <p class="text-neutral-500 mb-6">Yuk, isi keranjangmu dengan produk-produk pilihan!</p>
                        </div>
                        <a href="{{ route('products.index') }}" class="btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Mulai Belanja
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
