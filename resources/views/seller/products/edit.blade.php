<x-app-layout>
    <!-- Page Header -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Edit Produk</h1>
                    <p class="text-neutral-600">Perbarui informasi produk Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 bg-neutral-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Product Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Nama Produk</label>
                            <input 
                                id="name" 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $product->name) }}" 
                                required 
                                autofocus
                                class="input-field"
                            >
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-neutral-700 mb-2">Kategori</label>
                            <select id="category_id" name="category_id" required class="select-field">
                                <option value="">Pilih kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-neutral-700 mb-2">Deskripsi</label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="4" 
                                class="textarea-field"
                            >{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price and Stock Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Price -->
                            <div x-data="{
                                rawPrice: '{{ intval(old('price', $product->price)) }}',
                                formattedPrice: '',
                                formatPrice(value) {
                                    // Remove all non-digits
                                    let numbers = value.replace(/\D/g, '');
                                    
                                    // Store raw value
                                    this.rawPrice = numbers;
                                    
                                    // Format with dots as thousands separator
                                    this.formattedPrice = numbers.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                },
                                init() {
                                    // Initialize formatted value from raw price
                                    this.formatPrice(this.rawPrice.toString());
                                }
                            }">
                                <label for="price_display" class="block text-sm font-medium text-neutral-700 mb-2">Harga (Rp)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-neutral-500 font-medium">
                                        Rp
                                    </span>
                                    <input 
                                        id="price_display"
                                        type="text" 
                                        x-model="formattedPrice"
                                        @input="formatPrice($event.target.value)"
                                        placeholder="0"
                                        class="input-field pl-12"
                                        autocomplete="off"
                                    >
                                    <input 
                                        type="hidden" 
                                        name="price" 
                                        :value="rawPrice"
                                        required
                                    >
                                </div>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-neutral-700 mb-2">Stok</label>
                                <input 
                                    id="stock" 
                                    type="number" 
                                    name="stock" 
                                    value="{{ old('stock', $product->stock) }}" 
                                    min="0" 
                                    required
                                    class="input-field"
                                >
                                @error('stock')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Image -->
                        @if($product->image_url)
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Gambar Saat Ini</label>
                                <div class="relative inline-block">
                                    <img src="{{ Storage::url($product->image_url) }}" alt="{{ $product->name }}" class="h-40 w-40 object-cover rounded-lg border-2 border-neutral-200">
                                    <div class="absolute inset-0 bg-neutral-900 bg-opacity-0 hover:bg-opacity-10 rounded-lg transition-all"></div>
                                </div>
                            </div>
                        @endif

                        <!-- Product Image -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-neutral-700 mb-2">Gambar Produk</label>
                            <div class="mt-1">
                                <input 
                                    id="image" 
                                    type="file" 
                                    name="image" 
                                    accept="image/*"
                                    class="block w-full text-sm text-neutral-900 border border-neutral-300 rounded-lg cursor-pointer bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100"
                                >
                                <p class="mt-2 text-xs text-neutral-500">PNG, JPG, GIF hingga 2MB (Kosongkan jika tidak ingin mengubah gambar)</p>
                            </div>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Active -->
                        <div class="bg-neutral-50 border border-neutral-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <input 
                                    id="is_active" 
                                    type="checkbox" 
                                    name="is_active" 
                                    value="1" 
                                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                    class="w-4 h-4 text-primary-600 bg-white border-neutral-300 rounded focus:ring-primary-500 focus:ring-2"
                                >
                                <label for="is_active" class="ml-3 text-sm font-medium text-neutral-900">
                                    Aktif (Terlihat oleh pembeli)
                                </label>
                            </div>
                            <p class="ml-7 text-xs text-neutral-500 mt-1">Nonaktifkan untuk menyembunyikan produk dari pembeli</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-3 pt-6 border-t border-neutral-200">
                            <a href="{{ route('seller.products.index') }}" class="btn-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" class="btn-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Perbarui Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
