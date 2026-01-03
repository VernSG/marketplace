<x-app-layout>
    <!-- Page Header -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Verifikasi Pembayaran</h1>
                    <p class="text-neutral-600">{{ $order->invoice_number }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 bg-neutral-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('seller.orders.show', $order) }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium mb-6 group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Detail Pesanan
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

            <div class="card mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900">Ringkasan Pesanan</h3>
                </div>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral-600">Nomor Invoice</span>
                        <span class="font-semibold text-neutral-900">{{ $order->invoice_number }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral-600">Pelanggan</span>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded flex items-center justify-center text-white text-xs font-semibold">
                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                            </div>
                            <span class="font-semibold text-neutral-900">{{ $order->user->name }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral-600">Tanggal Pesanan</span>
                        <span class="font-semibold text-neutral-900">{{ $order->created_at->format('d F Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-neutral-200">
                        <span class="text-neutral-600">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-primary-600">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="border-t border-neutral-200 pt-6">
                    <h4 class="font-semibold text-neutral-900 mb-4">Item Pesanan</h4>
                    <div class="space-y-3">
                        @foreach($order->orderItems as $item)
                            <div class="flex justify-between items-center text-sm">
                                <div class="flex items-center gap-2 flex-1">
                                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <span class="text-neutral-700">{{ $item->product->name }}</span>
                                    <span class="text-neutral-400">×{{ $item->quantity }}</span>
                                </div>
                                <span class="font-medium text-neutral-900">Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($order->payment_proof)
                <div class="card mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900">Bukti Pembayaran</h3>
                    </div>
                    <div class="bg-neutral-50 rounded-xl p-6 border border-neutral-200">
                        <div class="flex justify-center">
                            <img src="{{ Storage::url($order->payment_proof) }}" alt="Payment Proof" class="max-w-full max-h-96 rounded-lg shadow-soft">
                        </div>
                        <p class="text-sm text-neutral-500 mt-4 text-center flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Klik gambar untuk melihat ukuran penuh
                        </p>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900">Tindakan Verifikasi</h3>
                </div>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-900 font-medium mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Harap periksa bukti pembayaran dengan teliti. Menerima pembayaran akan:
                    </p>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Mengubah status pesanan menjadi "Diproses"</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Mengurangi stok produk untuk setiap item</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Memungkinkan Anda untuk mengirim pesanan</span>
                        </li>
                    </ul>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <form action="{{ route('seller.orders.verify-payment', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full btn-success justify-center text-base py-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Terima Pembayaran & Proses
                        </button>
                    </form>

                    <button type="button" onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="btn-danger justify-center text-base py-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Tolak Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Payment Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative w-full max-w-md">
            <div class="bg-white rounded-xl shadow-soft-lg">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900">Tolak Pembayaran</h3>
                    </div>
                    
                    <form action="{{ route('seller.orders.reject-payment', $order) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="reason" class="block text-sm font-medium text-neutral-700 mb-2">
                                Alasan Penolakan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="reason" id="reason" rows="4" required class="input-field" placeholder="Berikan alasan yang jelas untuk menolak pembayaran ini..."></textarea>
                            <p class="text-xs text-neutral-500 mt-2">Alasan penolakan akan dikirimkan ke pelanggan</p>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="flex-1 btn-secondary justify-center">
                                Batal
                            </button>
                            <button type="submit" class="flex-1 btn-danger justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Konfirmasi Penolakan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
