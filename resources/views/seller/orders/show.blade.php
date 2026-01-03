<x-app-layout>
    <!-- Page Header -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Detail Pesanan</h1>
                    <p class="text-neutral-600">{{ $order->invoice_number }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 bg-neutral-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('seller.orders.index') }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium mb-6 group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Pesanan
            </a>

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

            <!-- Order Status Card -->
            <div class="card mb-6">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 pb-6 border-b border-neutral-200">
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                            {{ strtoupper(substr($order->user->name, 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-neutral-900">{{ $order->invoice_number }}</h3>
                            <p class="text-sm text-neutral-600 mt-1 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $order->created_at->format('d F Y, H:i') }}
                            </p>
                        </div>
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
                        <span class="badge {{ $config['class'] }} text-base px-4 py-2">
                            {{ $config['label'] }}
                        </span>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="pt-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-neutral-900">Informasi Pelanggan</h4>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div class="bg-neutral-50 rounded-lg p-3">
                            <p class="text-xs text-neutral-500 mb-1">Nama</p>
                            <p class="font-semibold text-neutral-900">{{ $order->user->name }}</p>
                        </div>
                        <div class="bg-neutral-50 rounded-lg p-3">
                            <p class="text-xs text-neutral-500 mb-1">Email</p>
                            <p class="font-semibold text-neutral-900">{{ $order->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items Card -->
            <div class="card mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-neutral-900">Item Pesanan</h4>
                </div>
                <div class="space-y-3">
                    @foreach($order->orderItems as $item)
                        <div class="flex gap-4 p-4 bg-neutral-50 rounded-xl hover:bg-neutral-100 transition-colors">
                            @if($item->product->image)
                                <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                            @else
                                <div class="w-20 h-20 bg-neutral-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h5 class="font-bold text-neutral-900 mb-1">{{ $item->product->name }}</h5>
                                <p class="text-sm text-neutral-600 mb-2">
                                    Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }} × {{ $item->quantity }}
                                </p>
                                <div class="flex items-center gap-2">
                                    <span class="badge badge-neutral text-xs">Stok: {{ $item->product->stock }}</span>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-xs text-neutral-500 mb-1">Subtotal</p>
                                <p class="text-xl font-bold text-primary-600">
                                    Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary Card -->
            <div class="card mb-6">
                <div class="flex items-center justify-between p-4 bg-gradient-to-br from-primary-50 to-blue-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-neutral-600 mb-1">Total Pembayaran</p>
                            <p class="text-3xl font-bold text-primary-600">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Proof -->
            @if($order->payment_proof)
                <div class="card mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-neutral-900">Bukti Pembayaran</h4>
                    </div>
                    <div class="bg-neutral-50 rounded-xl p-6 border border-neutral-200">
                        <div class="flex justify-center">
                            <img src="{{ Storage::url($order->payment_proof) }}" alt="Payment Proof" class="max-w-full rounded-lg shadow-soft">
                        </div>
                    </div>
                </div>
            @endif

            <!-- Cancellation Reason -->
            @if($order->status === 'cancelled' && $order->cancellation_reason)
                <div class="card mb-6 border-2 border-red-200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-red-600">Alasan Pembatalan</h4>
                    </div>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-sm text-red-900">{{ $order->cancellation_reason }}</p>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            @if($order->status === 'waiting_verification' || $order->status === 'processed')
                <div class="card">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-neutral-900">Tindakan</h4>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @if($order->status === 'waiting_verification')
                            <a href="{{ route('seller.orders.verify-payment-form', $order) }}" class="btn-success text-base px-6 py-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Verifikasi Pembayaran
                            </a>
                        @endif
                        @if($order->status === 'processed')
                            <form action="{{ route('seller.orders.mark-shipped', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-primary text-base px-6 py-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Tandai Sudah Dikirim
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
