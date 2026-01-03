<x-app-layout>
    <!-- Breadcrumb -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm mb-4">
                <a href="{{ route('home') }}" class="text-neutral-500 hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('cart.index') }}" class="text-neutral-500 hover:text-primary-600 transition-colors">Keranjang</a>
                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-neutral-900 font-medium">Checkout</span>
            </nav>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Checkout</h1>
                    <p class="text-neutral-600">Lengkapi data pengiriman dan pembayaran</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 bg-neutral-50">
    <div class="py-8 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('checkout.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Shipping & Payment Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Shipping Information -->
                        <div class="card">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-neutral-900">Informasi Pengiriman</h3>
                            </div>

                            <div class="space-y-4">
                                <!-- Shipping Address -->
                                <div>
                                    <label for="shipping_address" class="block text-sm font-medium text-neutral-700 mb-2">
                                        Alamat Pengiriman <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="shipping_address" name="shipping_address" rows="3" required
                                        class="input-field @error('shipping_address') border-red-500 @enderror" placeholder="Masukkan alamat lengkap pengiriman...">{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Shipping Courier -->
                                <div>
                                    <label for="shipping_courier" class="block text-sm font-medium text-neutral-700 mb-2">
                                        Jasa Pengiriman <span class="text-red-500">*</span>
                                    </label>
                                    <select id="shipping_courier" name="shipping_courier" required
                                        class="select-field @error('shipping_courier') border-red-500 @enderror">
                                        <option value="">Pilih Kurir</option>
                                        <option value="JNE" data-cost="15000" {{ old('shipping_courier') == 'JNE' ? 'selected' : '' }}>JNE - Rp 15.000</option>
                                        <option value="JNT" data-cost="12000" {{ old('shipping_courier') == 'JNT' ? 'selected' : '' }}>JNT - Rp 12.000</option>
                                        <option value="SiCepat" data-cost="13000" {{ old('shipping_courier') == 'SiCepat' ? 'selected' : '' }}>SiCepat - Rp 13.000</option>
                                        <option value="Anteraja" data-cost="11000" {{ old('shipping_courier') == 'Anteraja' ? 'selected' : '' }}>Anteraja - Rp 11.000</option>
                                    </select>
                                    @error('shipping_courier')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Shipping Cost -->
                                <div>
                                    <label for="shipping_cost" class="block text-sm font-medium text-neutral-700 mb-2">
                                        Biaya Pengiriman (Rp) <span class="text-red-500">*</span>
                                    </label>
                                    <input id="shipping_cost" class="input-field bg-neutral-100" type="number" name="shipping_cost" value="{{ old('shipping_cost', 0) }}" step="0.01" min="0" required readonly>
                                    <p class="mt-2 text-xs text-neutral-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Biaya akan otomatis terisi berdasarkan kurir yang dipilih
                                    </p>
                                    @error('shipping_cost')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="card">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-neutral-900">Informasi Pembayaran</h3>
                            </div>

                            <div class="space-y-4">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-blue-900 mb-1">Metode Pembayaran: <strong>Transfer Bank</strong></p>
                                            <p class="text-sm text-blue-800">Silakan transfer ke rekening lapak yang tertera di bawah, lalu upload bukti pembayaran.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bank Accounts by Shop -->
                                <div class="space-y-3">
                                    <h4 class="text-sm font-semibold text-neutral-900">Rekening Tujuan Transfer:</h4>
                                    @foreach($itemsByShop as $shopId => $items)
                                        @php
                                            $shop = $items->first()->product->shop;
                                        @endphp
                                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4">
                                            <div class="flex items-start gap-3 mb-3">
                                                <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center text-white text-sm font-semibold flex-shrink-0">
                                                    {{ strtoupper(substr($shop->name, 0, 2)) }}
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-bold text-neutral-900">{{ $shop->name }}</p>
                                                    <p class="text-xs text-neutral-600">
                                                        Total: Rp {{ number_format($items->sum(fn($item) => $item->product->price * $item->quantity), 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            @if($shop->bank_name && $shop->bank_account_number)
                                                <div class="bg-white rounded-lg p-3 space-y-2">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-xs text-neutral-500">Bank</span>
                                                        <span class="text-sm font-semibold text-neutral-900">{{ $shop->bank_name }}</span>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-xs text-neutral-500">No. Rekening</span>
                                                        <span class="text-sm font-bold text-primary-600">{{ $shop->bank_account_number }}</span>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-xs text-neutral-500">Atas Nama</span>
                                                        <span class="text-sm font-semibold text-neutral-900">{{ $shop->bank_account_holder ?? $shop->name }}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="bg-amber-50 border border-amber-200 rounded-lg p-3">
                                                    <p class="text-xs text-amber-800 flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                        </svg>
                                                        Lapak belum mengatur rekening bank. Hubungi penjual untuk informasi pembayaran.
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Payment Proof -->
                                <div>
                                    <label for="payment_proof" class="block text-sm font-medium text-neutral-700 mb-2">
                                        Bukti Pembayaran <span class="text-red-500">*</span>
                                    </label>
                                    <input id="payment_proof" class="input-field file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100 @error('payment_proof') border-red-500 @enderror" type="file" name="payment_proof" accept="image/*" required>
                                    <p class="mt-2 text-xs text-neutral-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Format: PNG, JPG maksimal 2MB
                                    </p>
                                    @error('payment_proof')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="card sticky top-4">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-neutral-900">Ringkasan Pesanan</h3>
                            </div>

                            <!-- Items grouped by shop -->
                            <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                                @foreach($itemsByShop as $shopId => $items)
                                    <div class="pb-4 border-b border-neutral-200 last:border-0">
                                        <div class="flex items-center gap-2 mb-3">
                                            <div class="w-6 h-6 bg-gradient-to-br from-primary-500 to-primary-600 rounded flex items-center justify-center text-white text-xs font-semibold">
                                                {{ strtoupper(substr($items->first()->product->shop->name, 0, 1)) }}
                                            </div>
                                            <p class="font-semibold text-sm text-neutral-900">
                                                {{ $items->first()->product->shop->name }}
                                            </p>
                                        </div>
                                        @foreach($items as $item)
                                            <div class="flex justify-between text-sm text-neutral-600 mb-2">
                                                <span class="flex-1">{{ $item->product->name }} <span class="text-neutral-400">×{{ $item->quantity }}</span></span>
                                                <span class="font-medium text-neutral-900 ml-2">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-neutral-200 pt-4 space-y-3">
                                <div class="flex justify-between text-sm text-neutral-600">
                                    <span>Subtotal</span>
                                    <span class="font-medium text-neutral-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-neutral-600">
                                    <span>Biaya Pengiriman</span>
                                    <span id="shipping-cost-display" class="font-medium text-neutral-900">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold text-neutral-900 pt-3 border-t border-neutral-200">
                                    <span>Total</span>
                                    <span id="total-display" class="text-primary-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full mt-6 btn-primary justify-center text-base py-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Buat Pesanan
                            </button>

                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mt-4">
                                <p class="text-xs text-amber-800 text-center flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $itemsByShop->count() }} pesanan akan dibuat (satu per lapak)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const subtotal = {{ $total }};
        const shippingCostInput = document.getElementById('shipping_cost');
        const courierSelect = document.getElementById('shipping_courier');
        
        // Update shipping cost when courier is selected
        courierSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const shippingCost = parseFloat(selectedOption.getAttribute('data-cost')) || 0;
            
            // Update shipping cost input
            shippingCostInput.value = shippingCost;
            
            // Update display
            updateTotal(shippingCost);
        });
        
        // Update total when shipping cost changes
        shippingCostInput.addEventListener('input', function() {
            const shippingCost = parseFloat(this.value) || 0;
            updateTotal(shippingCost);
        });
        
        function updateTotal(shippingCost) {
            const total = subtotal + shippingCost;
            
            document.getElementById('shipping-cost-display').textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
            document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        
        // Initialize if courier is already selected (e.g., after validation error)
        if (courierSelect.value) {
            const selectedOption = courierSelect.options[courierSelect.selectedIndex];
            const shippingCost = parseFloat(selectedOption.getAttribute('data-cost')) || 0;
            shippingCostInput.value = shippingCost;
            updateTotal(shippingCost);
        }
    </script>
</x-app-layout>
