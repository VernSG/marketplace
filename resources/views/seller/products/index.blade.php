<x-app-layout>
    <!-- Page Header -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-900">Produk Saya</h1>
                        <p class="text-neutral-600">Kelola semua produk lapak Anda</p>
                    </div>
                </div>
                <a href="{{ route('seller.products.create') }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Produk
                </a>
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

            @if($products->count() > 0)
                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="card group hover:shadow-md transition-shadow">
                            <!-- Image Container -->
                            <div class="aspect-square overflow-hidden rounded-lg bg-neutral-100 mb-4 relative">
                                @if($product->image_url)
                                    <img 
                                        src="{{ Storage::url($product->image_url) }}" 
                                        alt="{{ $product->name }}" 
                                        class="w-full h-full object-cover"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-neutral-100 to-neutral-200">
                                        <svg class="w-16 h-16 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Status Badge -->
                                <div class="absolute top-3 right-3">
                                    @if($product->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </div>
                                
                                <!-- Stock Badge -->
                                @if($product->stock == 0)
                                    <div class="absolute top-3 left-3">
                                        <span class="badge badge-danger">Habis</span>
                                    </div>
                                @elseif($product->stock < 10)
                                    <div class="absolute top-3 left-3">
                                        <span class="badge badge-warning">Stok Rendah</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="space-y-3">
                                <!-- Category -->
                                <p class="text-xs text-neutral-400 uppercase tracking-wide">
                                    {{ $product->category->name }}
                                </p>
                                
                                <!-- Product Name -->
                                <h3 class="font-semibold text-neutral-900 line-clamp-2 h-12">
                                    {{ $product->name }}
                                </h3>
                                
                                <!-- Price and Stock -->
                                <div class="flex items-center justify-between pt-3 border-t border-neutral-200">
                                    <div>
                                        <p class="text-sm text-neutral-500 mb-1">Harga</p>
                                        <p class="text-lg font-bold text-primary-600">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-neutral-500 mb-1">Stok</p>
                                        <p class="text-lg font-bold text-neutral-900">
                                            {{ $product->stock }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex gap-2 pt-3 border-t border-neutral-200">
                                    <a href="{{ route('seller.products.edit', $product) }}" class="flex-1 btn-secondary text-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full btn-danger">
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

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="card text-center py-16">
                    <div class="flex flex-col items-center gap-6">
                        <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-neutral-900 mb-2">Belum Ada Produk</h3>
                            <p class="text-neutral-500 mb-6">Mulai berjualan dengan menambahkan produk pertama Anda!</p>
                        </div>
                        <a href="{{ route('seller.products.create') }}" class="btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Buat Produk Pertama
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
