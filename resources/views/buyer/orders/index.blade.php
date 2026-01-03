<x-app-layout>
    <!-- Page Header -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Pesanan Saya</h1>
                    <p class="text-neutral-600">Kelola dan lacak semua pesanan Anda</p>
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

            @if(!$ordersByStatus->isEmpty())
                <!-- Status Tabs -->
                <div class="mb-6 bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <ul class="flex min-w-full" role="tablist">
                            @foreach($statusOrder as $status)
                                @if($ordersByStatus->has($status))
                                    <li class="flex-1" role="presentation">
                                        <button class="w-full status-tab px-6 py-4 text-sm font-medium text-neutral-600 hover:text-primary-600 hover:bg-neutral-50 transition-all duration-200 border-b-2 border-transparent" 
                                            data-status="{{ $status }}"
                                            type="button" 
                                            role="tab">
                                            <div class="flex flex-col items-center gap-2">
                                                <span>{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                                                <span class="badge badge-neutral text-xs">
                                                    {{ $ordersByStatus[$status]->count() }}
                                                </span>
                                            </div>
                                        </button>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Tab Contents -->
                @foreach($statusOrder as $status)
                    @if($ordersByStatus->has($status))
                        <div class="status-content hidden" data-status="{{ $status }}">
                            <div class="space-y-4">
                                @foreach($ordersByStatus[$status] as $order)
                                    <div class="card hover:shadow-md transition-shadow">
                                        <!-- Order Header -->
                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 pb-4 border-b border-neutral-200">
                                            <div class="flex items-start gap-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center text-white font-semibold flex-shrink-0">
                                                    {{ strtoupper(substr($order->shop->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-neutral-900">{{ $order->invoice_number }}</h3>
                                                    <p class="text-sm text-neutral-600">{{ $order->shop->name }}</p>
                                                    <p class="text-xs text-neutral-400 mt-1 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        {{ $order->created_at->format('d M Y, H:i') }}
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
                                                <span class="badge {{ $config['class'] }}">
                                                    {{ $config['label'] }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Order Items -->
                                        <div class="py-4 space-y-2">
                                            @foreach($order->orderItems as $item)
                                                <div class="flex items-center justify-between text-sm">
                                                    <div class="flex items-center gap-2 flex-1 min-w-0">
                                                        <svg class="w-4 h-4 text-neutral-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                        </svg>
                                                        <span class="text-neutral-700 truncate">{{ $item->product->name }}</span>
                                                        <span class="text-neutral-400">×{{ $item->quantity }}</span>
                                                    </div>
                                                    <span class="font-medium text-neutral-900 ml-4">
                                                        Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Order Footer -->
                                        <div class="pt-4 border-t border-neutral-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                            <div>
                                                <p class="text-xs text-neutral-500 mb-1">Total Pembayaran</p>
                                                <p class="text-2xl font-bold text-primary-600">
                                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <div class="flex flex-wrap gap-2">
                                                @if($order->status === 'pending')
                                                    <a href="{{ route('buyer.orders.upload-proof-form', $order) }}" class="btn-success">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                        </svg>
                                                        Upload Pembayaran
                                                    </a>
                                                @endif
                                                <a href="{{ route('buyer.orders.print-receipt', $order) }}" target="_blank" class="btn-secondary">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                                    </svg>
                                                    Cetak Struk
                                                </a>
                                                <a href="{{ route('buyer.orders.show', $order) }}" class="btn-secondary">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <!-- Empty State -->
                <div class="card text-center py-16">
                    <div class="flex flex-col items-center gap-6">
                        <div class="w-24 h-24 bg-neutral-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-neutral-900 mb-2">Belum Ada Pesanan</h3>
                            <p class="text-neutral-500 mb-6">Mulai belanja dan temukan produk favorit Anda!</p>
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

    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.status-tab');
            const contents = document.querySelectorAll('.status-content');
            
            if (tabs.length > 0) {
                // Show first tab by default
                tabs[0].classList.add('border-primary-600', 'text-primary-600', 'bg-primary-50');
                contents[0].classList.remove('hidden');
                
                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        const status = this.getAttribute('data-status');
                        
                        // Remove active class from all tabs
                        tabs.forEach(t => {
                            t.classList.remove('border-primary-600', 'text-primary-600', 'bg-primary-50');
                        });
                        
                        // Add active class to clicked tab
                        this.classList.add('border-primary-600', 'text-primary-600', 'bg-primary-50');
                        
                        // Hide all contents
                        contents.forEach(content => {
                            content.classList.add('hidden');
                        });
                        
                        // Show selected content
                        document.querySelector(`.status-content[data-status="${status}"]`).classList.remove('hidden');
                    });
                });
            }
        });
    </script>
</x-app-layout>
