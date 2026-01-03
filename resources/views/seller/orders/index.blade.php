<x-app-layout>
    <!-- Page Header -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Kelola Pesanan</h1>
                    <p class="text-neutral-600">Proses dan pantau semua pesanan lapak Anda</p>
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

            <!-- Status Filter Tabs -->
            <div class="mb-6 bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <div class="flex min-w-full">
                        <a href="{{ route('seller.orders.index') }}" class="flex-1 px-4 py-4 text-center text-sm font-medium transition-all duration-200 border-b-2 {{ !request('status') ? 'border-primary-600 text-primary-600 bg-primary-50' : 'border-transparent text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <div class="flex flex-col items-center gap-1">
                                <span>Semua</span>
                                <span class="badge badge-neutral text-xs">{{ $statusCounts['all'] }}</span>
                            </div>
                        </a>
                        <a href="{{ route('seller.orders.index', ['status' => 'pending']) }}" class="flex-1 px-4 py-4 text-center text-sm font-medium transition-all duration-200 border-b-2 {{ request('status') === 'pending' ? 'border-amber-600 text-amber-600 bg-amber-50' : 'border-transparent text-neutral-600 hover:text-amber-600 hover:bg-neutral-50' }}">
                            <div class="flex flex-col items-center gap-1">
                                <span>Pending</span>
                                <span class="badge badge-warning text-xs">{{ $statusCounts['pending'] }}</span>
                            </div>
                        </a>
                        <a href="{{ route('seller.orders.index', ['status' => 'waiting_verification']) }}" class="flex-1 px-4 py-4 text-center text-sm font-medium transition-all duration-200 border-b-2 {{ request('status') === 'waiting_verification' ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-neutral-600 hover:text-blue-600 hover:bg-neutral-50' }}">
                            <div class="flex flex-col items-center gap-1">
                                <span>Verifikasi</span>
                                <span class="badge badge-primary text-xs">{{ $statusCounts['waiting_verification'] }}</span>
                            </div>
                        </a>
                        <a href="{{ route('seller.orders.index', ['status' => 'processed']) }}" class="flex-1 px-4 py-4 text-center text-sm font-medium transition-all duration-200 border-b-2 {{ request('status') === 'processed' ? 'border-neutral-600 text-neutral-600 bg-neutral-50' : 'border-transparent text-neutral-600 hover:text-neutral-600 hover:bg-neutral-50' }}">
                            <div class="flex flex-col items-center gap-1">
                                <span>Diproses</span>
                                <span class="badge badge-neutral text-xs">{{ $statusCounts['processed'] }}</span>
                            </div>
                        </a>
                        <a href="{{ route('seller.orders.index', ['status' => 'shipped']) }}" class="flex-1 px-4 py-4 text-center text-sm font-medium transition-all duration-200 border-b-2 {{ request('status') === 'shipped' ? 'border-primary-600 text-primary-600 bg-primary-50' : 'border-transparent text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <div class="flex flex-col items-center gap-1">
                                <span>Dikirim</span>
                                <span class="badge badge-primary text-xs">{{ $statusCounts['shipped'] }}</span>
                            </div>
                        </a>
                        <a href="{{ route('seller.orders.index', ['status' => 'completed']) }}" class="flex-1 px-4 py-4 text-center text-sm font-medium transition-all duration-200 border-b-2 {{ request('status') === 'completed' ? 'border-green-600 text-green-600 bg-green-50' : 'border-transparent text-neutral-600 hover:text-green-600 hover:bg-neutral-50' }}">
                            <div class="flex flex-col items-center gap-1">
                                <span>Selesai</span>
                                <span class="badge badge-success text-xs">{{ $statusCounts['completed'] }}</span>
                            </div>
                        </a>
                        <a href="{{ route('seller.orders.index', ['status' => 'cancelled']) }}" class="flex-1 px-4 py-4 text-center text-sm font-medium transition-all duration-200 border-b-2 {{ request('status') === 'cancelled' ? 'border-red-600 text-red-600 bg-red-50' : 'border-transparent text-neutral-600 hover:text-red-600 hover:bg-neutral-50' }}">
                            <div class="flex flex-col items-center gap-1">
                                <span>Batal</span>
                                <span class="badge badge-danger text-xs">{{ $statusCounts['cancelled'] }}</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            @if($orders->count() > 0)
                <!-- Orders List -->
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="card hover:shadow-md transition-shadow">
                            <!-- Order Header -->
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 pb-4 border-b border-neutral-200">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-semibold flex-shrink-0">
                                        {{ strtoupper(substr($order->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-neutral-900">{{ $order->invoice_number }}</h3>
                                        <p class="text-sm text-neutral-600">{{ $order->user->name }}</p>
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
                                    @if($order->status === 'waiting_verification')
                                        <a href="{{ route('seller.orders.verify-payment-form', $order) }}" class="btn-success">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Verifikasi Pembayaran
                                        </a>
                                    @endif
                                    @if($order->status === 'processed')
                                        <form action="{{ route('seller.orders.mark-shipped', $order) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-primary">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Tandai Dikirim
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('seller.orders.show', $order) }}" class="btn-secondary">
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

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="card text-center py-16">
                    <div class="flex flex-col items-center gap-6">
                        <div class="w-24 h-24 bg-neutral-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-neutral-900 mb-2">Tidak Ada Pesanan</h3>
                            <p class="text-neutral-500">Belum ada pesanan untuk filter yang dipilih.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
