<x-app-layout>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <h1 class="text-5xl font-bold text-neutral-900 mb-4 leading-tight">
                        Temukan Barang Impianmu
                    </h1>
                    <p class="text-xl text-neutral-600 mb-8">
                        Ribuan produk berkualitas dari seller terpercaya, semua dalam satu marketplace modern
                    </p>
                    
                    @guest
                        <div class="flex items-center gap-4">
                            <a href="{{ route('register') }}" class="btn-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Mulai Belanja
                            </a>
                            <a href="{{ route('register') }}" class="btn-secondary">
                                Daftar Sebagai Seller
                            </a>
                        </div>
                    @endguest
                </div>

                <!-- Right Illustration Placeholder -->
                <div class="hidden lg:flex items-center justify-center">
                    <div class="w-full h-80 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center">
                        <svg class="w-48 h-48 text-primary-600 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="sticky top-0 z-10 bg-white border-b border-neutral-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <form method="GET" action="{{ route('products.index') }}" class="max-w-3xl mx-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                        <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari produk, kategori, atau lapak..." 
                        class="w-full rounded-full border-neutral-200 bg-white pl-14 pr-14 py-4 text-neutral-900 placeholder-neutral-400 shadow-md transition-all duration-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 focus:outline-none"
                        oninput="this.form.submit()"
                    >
                    @if(request('search') || request('category'))
                        <a href="{{ route('products.index') }}" class="absolute inset-y-0 right-6 flex items-center text-neutral-500 hover:text-neutral-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Products Section -->
    <div class="py-12 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($products->count() > 0)
                <!-- Product Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-neutral-100 overflow-hidden">
                            <!-- Image Container -->
                            <a href="{{ route('products.show', $product->slug) }}" class="block aspect-square overflow-hidden rounded-t-xl bg-neutral-100 relative">
                                @if($product->image_url)
                                    <img 
                                        src="{{ Storage::url($product->image_url) }}" 
                                        alt="{{ $product->name }}" 
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-neutral-100 to-neutral-200">
                                        <svg class="w-20 h-20 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-neutral-900 bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                                    <span class="text-white font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-primary-600 px-6 py-2 rounded-full transform translate-y-2 group-hover:translate-y-0">
                                        Lihat Detail
                                    </span>
                                </div>

                                <!-- Stock Badge -->
                                @if($product->stock == 0)
                                    <div class="absolute top-3 right-3">
                                        <span class="badge badge-danger">Habis</span>
                                    </div>
                                @elseif($product->stock < 10)
                                    <div class="absolute top-3 right-3">
                                        <span class="badge badge-warning">Stok Terbatas</span>
                                    </div>
                                @endif
                            </a>
                            
                            <!-- Card Content -->
                            <div class="p-4">
                                <!-- Category -->
                                <p class="text-xs text-neutral-400 uppercase tracking-wide mb-2">
                                    {{ $product->category->name }}
                                </p>
                                
                                <!-- Product Title -->
                                <a href="{{ route('products.show', $product->slug) }}" class="block">
                                    <h3 class="font-semibold text-neutral-900 line-clamp-2 hover:text-primary-600 transition-colors mb-2 h-12">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                
                                <!-- Shop Name -->
                                <p class="text-sm text-neutral-500 mb-3">
                                    {{ $product->shop->name }}
                                </p>
                                
                                <!-- Price and Action -->
                                <div class="flex items-center justify-between pt-3 border-t border-neutral-100">
                                    <div>
                                        <span class="text-lg font-bold text-primary-600">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        <p class="text-xs text-neutral-400">
                                            Stok: {{ $product->stock }}
                                        </p>
                                    </div>
                                    
                                    @auth
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button 
                                                type="submit" 
                                                class="p-2 rounded-lg bg-primary-50 text-primary-600 hover:bg-primary-600 hover:text-white transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed" 
                                                {{ $product->stock == 0 ? 'disabled' : '' }}
                                                title="Tambah ke Keranjang"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <a 
                                            href="{{ route('login') }}" 
                                            class="p-2 rounded-lg bg-neutral-100 text-neutral-600 hover:bg-neutral-200 transition-all duration-200"
                                            title="Login untuk Membeli"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                            </svg>
                                        </a>
                                    @endauth
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
                    <div class="flex flex-col items-center gap-4">
                        <svg class="w-24 h-24 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h3 class="text-xl font-semibold text-neutral-900 mb-2">Tidak Ada Produk</h3>
                            <p class="text-neutral-500">Produk yang Anda cari tidak ditemukan. Coba kata kunci lain.</p>
                        </div>
                        @if(request('search') || request('category'))
                            <a href="{{ route('products.index') }}" class="btn-primary mt-4">
                                Lihat Semua Produk
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
