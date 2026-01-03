<x-app-layout>
    <!-- Page Header -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Edit Lapak</h1>
                    <p class="text-neutral-600">Perbarui informasi lapak Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 bg-neutral-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <form method="POST" action="{{ route('shop.update') }}">
                    @csrf
                    @method('PATCH')

                    <!-- Shop Information Section -->
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-neutral-900">Informasi Lapak</h3>
                        </div>

                        <!-- Shop Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">
                                Nama Lapak <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $shop->name) }}" required
                                class="input-field @error('name') border-red-500 @enderror" placeholder="Masukkan nama lapak Anda...">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-neutral-700 mb-2">
                                Deskripsi Lapak
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="textarea-field @error('description') border-red-500 @enderror" placeholder="Ceritakan tentang lapak Anda...">{{ old('description', $shop->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-neutral-700 mb-2">
                                Alamat Lapak
                            </label>
                            <textarea name="address" id="address" rows="3"
                                class="textarea-field @error('address') border-red-500 @enderror" placeholder="Masukkan alamat lengkap lapak...">{{ old('address', $shop->address) }}</textarea>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Bank Details Section -->
                    <div class="border-t border-neutral-200 pt-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-neutral-900">Informasi Rekening Bank</h3>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm text-blue-800">Informasi rekening ini akan ditampilkan kepada pembeli untuk transfer pembayaran.</p>
                            </div>
                        </div>

                        <!-- Bank Name -->
                        <div class="mb-4">
                            <label for="bank_name" class="block text-sm font-medium text-neutral-700 mb-2">
                                Nama Bank <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $shop->bank_name) }}" required
                                class="input-field @error('bank_name') border-red-500 @enderror" placeholder="Contoh: BCA, Mandiri, BNI...">
                            @error('bank_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bank Account Number -->
                        <div class="mb-4">
                            <label for="bank_account_number" class="block text-sm font-medium text-neutral-700 mb-2">
                                Nomor Rekening <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="bank_account_number" id="bank_account_number" value="{{ old('bank_account_number', $shop->bank_account_number) }}" required
                                class="input-field @error('bank_account_number') border-red-500 @enderror" placeholder="Masukkan nomor rekening...">
                            @error('bank_account_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bank Account Holder -->
                        <div>
                            <label for="bank_account_holder" class="block text-sm font-medium text-neutral-700 mb-2">
                                Nama Pemilik Rekening <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="bank_account_holder" id="bank_account_holder" value="{{ old('bank_account_holder', $shop->bank_account_holder) }}" required
                                class="input-field @error('bank_account_holder') border-red-500 @enderror" placeholder="Nama sesuai rekening bank...">
                            @error('bank_account_holder')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-3 pt-6 border-t border-neutral-200">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Perbarui Lapak
                        </button>
                        <a href="{{ route('seller.dashboard') }}" class="btn-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
