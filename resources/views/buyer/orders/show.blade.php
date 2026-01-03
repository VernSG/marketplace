<x-app-layout>
    <!-- Page Header -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Detail Pesanan</h1>
                    <p class="text-neutral-600">Informasi lengkap pesanan Anda</p>
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

            <div class="card">
                <!-- Order Header -->
                <div class="mb-6 pb-6 border-b border-neutral-200">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-neutral-900 mb-2">{{ $order->invoice_number }}</h2>
                            <p class="text-sm text-neutral-600 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $order->created_at->format('d F Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            @php
                                $statusConfig = [
                                    'pending' => ['class' => 'badge-warning', 'label' => 'Menunggu Pembayaran'],
                                    'waiting_verification' => ['class' => 'badge-primary', 'label' => 'Verifikasi Pembayaran'],
                                    'processed' => ['class' => 'badge badge-neutral', 'label' => 'Diproses'],
                                    'shipped' => ['class' => 'badge-primary', 'label' => 'Dikirim'],
                                    'completed' => ['class' => 'badge-success', 'label' => 'Selesai'],
                                    'cancelled' => ['class' => 'badge-danger', 'label' => 'Dibatalkan'],
                                ];
                                $config = $statusConfig[$order->status] ?? ['class' => 'badge-neutral', 'label' => ucfirst(str_replace('_', ' ', $order->status))];
                            @endphp
                            <span class="badge {{ $config['class'] }}">
                                {{ $config['label'] }}
                            </span>
                        </div>
                    </div>

                    @if($order->status === 'pending')
                        <div class="mt-4 bg-amber-50 border border-amber-200 p-4 rounded-lg">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-amber-800 mb-2">Upload bukti pembayaran untuk melanjutkan pesanan ini</p>
                                    <a href="{{ route('buyer.orders.upload-proof-form', $order) }}" class="btn-success inline-flex">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        Upload Bukti Pembayaran
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Shop Information & Bank Details -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <h4 class="font-bold text-lg text-neutral-900">Informasi Lapak</h4>
                        </div>
                        <div class="bg-neutral-50 border border-neutral-200 p-4 rounded-lg">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center text-white font-semibold flex-shrink-0">
                                    {{ strtoupper(substr($order->shop->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-neutral-900 mb-1">{{ $order->shop->name }}</p>
                                    @if($order->shop->address)
                                        <p class="text-sm text-neutral-600">{{ $order->shop->address }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <h4 class="font-bold text-lg text-neutral-900">Rekening Tujuan</h4>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-neutral-600">Bank</span>
                                    <span class="font-semibold text-neutral-900">{{ $order->shop->bank_name }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-neutral-600">No. Rekening</span>
                                    <span class="font-semibold text-neutral-900">{{ $order->shop->bank_account_number }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-neutral-600">Atas Nama</span>
                                    <span class="font-semibold text-neutral-900">{{ $order->shop->bank_account_holder }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10"/>
                        </svg>
                        <h4 class="font-bold text-lg text-neutral-900">Informasi Pengiriman</h4>
                    </div>
                    <div class="bg-neutral-50 border border-neutral-200 p-4 rounded-lg space-y-3">
                        <div>
                            <p class="text-xs text-neutral-500 mb-1">Alamat Pengiriman</p>
                            <p class="text-sm font-medium text-neutral-900">{{ $order->shipping_address }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-neutral-500 mb-1">Kurir</p>
                                <p class="text-sm font-medium text-neutral-900">{{ $order->shipping_courier }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-neutral-500 mb-1">Biaya Pengiriman</p>
                                <p class="text-sm font-medium text-primary-600">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <h4 class="font-bold text-lg text-neutral-900">Daftar Produk</h4>
                    </div>
                    <div class="space-y-3">
                        @foreach($order->orderItems as $item)
                            <div class="bg-white border border-neutral-200 rounded-lg p-4 hover:shadow-sm transition-shadow">
                                <div class="flex gap-4">
                                    @if($item->product->image_url)
                                        <img src="{{ Storage::url($item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                                    @else
                                        <div class="w-20 h-20 bg-gradient-to-br from-neutral-100 to-neutral-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-semibold text-neutral-900 mb-1">{{ $item->product->name }}</h5>
                                        <div class="flex items-center gap-4 text-sm text-neutral-600 mb-1">
                                            <span>Qty: {{ $item->quantity }}</span>
                                            <span>@</span>
                                            <span>Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</span>
                                        </div>
                                        @if($item->note)
                                            <div class="mt-2 bg-blue-50 border border-blue-200 rounded px-3 py-2">
                                                <p class="text-xs text-blue-800"><span class="font-semibold">Catatan:</span> {{ $item->note }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-right flex-shrink-0">
                                        <p class="text-sm text-neutral-500 mb-1">Subtotal</p>
                                        <p class="font-bold text-lg text-primary-600">Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <h4 class="font-bold text-lg text-neutral-900">Informasi Pembayaran</h4>
                    </div>
                    <div class="bg-neutral-50 border border-neutral-200 p-4 rounded-lg">
                        <div class="mb-3">
                            <p class="text-xs text-neutral-500 mb-1">Metode Pembayaran</p>
                            <p class="text-sm font-medium text-neutral-900">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                        </div>
                        @if($order->payment_proof)
                            <div>
                                <p class="text-xs text-neutral-500 mb-2">Bukti Pembayaran</p>
                                <img src="{{ Storage::url($order->payment_proof) }}" alt="Payment Proof" class="w-full max-w-md rounded-lg border border-neutral-300 shadow-sm">
                            </div>
                        @else
                            <div class="bg-amber-50 border border-amber-200 rounded-lg px-3 py-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-amber-800">Bukti pembayaran belum diupload</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="border-t border-neutral-200 pt-6">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <h4 class="font-bold text-lg text-neutral-900">Ringkasan Pesanan</h4>
                    </div>
                    <div class="bg-neutral-50 border border-neutral-200 rounded-lg p-4">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600">Subtotal Produk</span>
                                <span class="font-medium text-neutral-900">Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600">Biaya Pengiriman</span>
                                <span class="font-medium text-neutral-900">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold pt-3 border-t border-neutral-200">
                                <span class="text-neutral-900">Total Pembayaran</span>
                                <span class="text-primary-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cancellation Note -->
                @if($order->status === 'cancelled' && $order->cancellation_note)
                    <div class="mt-6 bg-red-50 border border-red-200 p-4 rounded-lg">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-red-800 mb-1">Alasan Pembatalan</h4>
                                <p class="text-sm text-red-700">{{ $order->cancellation_note }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="mt-6 flex flex-wrap gap-3">
                    @if($order->status === 'shipped')
                        <form action="{{ route('buyer.orders.mark-completed', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin telah menerima pesanan ini?')">
                            @csrf
                            <button type="submit" class="btn-success">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pesanan Diterima
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('buyer.orders.print-receipt', $order) }}" target="_blank" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Cetak Struk
                    </a>
                    
                    <a href="{{ route('buyer.orders.index') }}" class="btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Daftar Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
