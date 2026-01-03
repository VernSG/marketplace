<x-app-layout>
    <!-- Page Header -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Tambah Produk Baru</h1>
                    <p class="text-neutral-600">Isi form di bawah untuk menambahkan produk</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 bg-neutral-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Product Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Nama Produk</label>
                            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-neutral-700 mb-2">Kategori</label>
                            <select id="category_id" name="category_id" class="block w-full border-neutral-300 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm" required>
                                <option value="">Pilih kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-neutral-700 mb-2">Deskripsi</label>
                            <textarea id="description" name="description" rows="4" 
                                class="block w-full border-neutral-300 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm" placeholder="Jelaskan detail produk Anda...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Price & Stock Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-neutral-700 mb-2">Harga (Rp)</label>
                                <x-text-input id="price" class="block w-full" type="number" name="price" :value="old('price')" step="0.01" min="0" required placeholder="0" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Stock -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-neutral-700 mb-2">Stok</label>
                                <x-text-input id="stock" class="block w-full" type="number" name="stock" :value="old('stock')" min="0" required placeholder="0" />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-neutral-700 mb-2">Gambar Produk</label>
                            <input id="image" class="block w-full text-sm text-neutral-900 border border-neutral-300 rounded-lg cursor-pointer bg-neutral-50 focus:outline-none focus:border-primary-500" type="file" name="image" accept="image/*">
                            <p class="mt-2 text-xs text-neutral-500">PNG, JPG, GIF maksimal 2MB</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <!-- Is Active -->
                        <div class="flex items-center p-4 bg-neutral-50 rounded-lg">
                            <input id="is_active" type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-primary-600 bg-white border-neutral-300 rounded focus:ring-primary-500">
                            <label for="is_active" class="ml-3 text-sm font-medium text-neutral-700">Aktifkan produk (terlihat oleh pembeli)</label>
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
                                Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
