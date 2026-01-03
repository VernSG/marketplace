<x-app-layout>
    <!-- Breadcrumb -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="text-neutral-500 hover:text-primary-600 transition-colors">Beranda</a>
                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('products.index') }}" class="text-neutral-500 hover:text-primary-600 transition-colors">Produk</a>
                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-neutral-900 font-medium">{{ $product->name }}</span>
            </nav>
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

            <!-- Product Detail Card -->
            <div class="card mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Product Image -->
                    <div>
                        <div class="aspect-square rounded-xl overflow-hidden bg-neutral-100">
                            @if($product->image_url)
                                <img src="{{ Storage::url($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-neutral-100 to-neutral-200">
                                    <svg class="w-32 h-32 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div>
                        <!-- Category Badge -->
                        <div class="mb-3">
                            <span class="badge badge-primary">{{ $product->category->name }}</span>
                        </div>

                        <!-- Product Title -->
                        <h1 class="text-3xl font-bold text-neutral-900 mb-4">{{ $product->name }}</h1>
                        
                        <!-- Shop Info -->
                        <div class="flex items-center gap-3 mb-6 pb-6 border-b border-neutral-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($product->shop->name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-xs text-neutral-500">Dijual oleh</p>
                                <p class="font-semibold text-neutral-900">{{ $product->shop->name }}</p>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mb-6">
                            <p class="text-sm text-neutral-500 mb-1">Harga</p>
                            <p class="text-4xl font-bold text-primary-600">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Stock Info -->
                        <div class="mb-6 p-4 bg-neutral-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-neutral-600">Stok Tersedia</span>
                                <span class="font-semibold text-neutral-900">{{ $product->stock }} unit</span>
                            </div>
                            @if($product->stock < 10 && $product->stock > 0)
                                <p class="text-xs text-orange-600 mt-2">Stok terbatas, segera pesan!</p>
                            @endif
                        </div>

                        <!-- Description -->
                        @if($product->description)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-neutral-900 mb-3">Deskripsi Produk</h3>
                                <p class="text-neutral-600 whitespace-pre-line leading-relaxed">{{ $product->description }}</p>
                            </div>
                        @endif

                        <!-- Add to Cart Form -->
                        @auth
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div>
                                        <label for="quantity" class="block text-sm font-medium text-neutral-900 mb-2">Jumlah</label>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                            class="input-field w-32">
                                    </div>

                                    <div class="flex gap-3">
                                        <button type="submit" class="btn-primary flex-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                            </svg>
                                            Tambah ke Keranjang
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">Stok Habis</span>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-secondary w-full">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Login untuk Membeli
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-neutral-900">Produk Terkait</h2>
                        <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm flex items-center gap-1">
                            Lihat Semua
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($relatedProducts as $related)
                            <div class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-neutral-100 overflow-hidden">
                                <!-- Image Container -->
                                <a href="{{ route('products.show', $related->slug) }}" class="block aspect-square overflow-hidden bg-neutral-100 relative">
                                    @if($related->image_url)
                                        <img 
                                            src="{{ Storage::url($related->image_url) }}" 
                                            alt="{{ $related->name }}" 
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                        >
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-neutral-100 to-neutral-200">
                                            <svg class="w-16 h-16 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Hover Overlay -->
                                    <div class="absolute inset-0 bg-neutral-900 bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>

                                    <!-- Stock Badge -->
                                    @if($related->stock == 0)
                                        <div class="absolute top-2 right-2">
                                            <span class="badge badge-danger text-xs">Habis</span>
                                        </div>
                                    @endif
                                </a>
                                
                                <!-- Card Content -->
                                <div class="p-3">
                                    <!-- Product Title -->
                                    <a href="{{ route('products.show', $related->slug) }}" class="block">
                                        <h3 class="font-semibold text-sm text-neutral-900 line-clamp-2 hover:text-primary-600 transition-colors mb-2 h-10">
                                            {{ $related->name }}
                                        </h3>
                                    </a>
                                    
                                    <!-- Price -->
                                    <p class="text-base font-bold text-primary-600">
                                        Rp {{ number_format($related->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
