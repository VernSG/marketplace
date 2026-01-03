<x-app-layout>
    <!-- Page Header -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Buat Lapak Baru</h1>
                    <p class="text-neutral-600">Lengkapi informasi lapak Anda untuk mulai berjualan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 bg-neutral-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <form method="POST" action="{{ route('shop.store') }}" class="space-y-6">
                    @csrf

                    <!-- Shop Information Section -->
                    <div>
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
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
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
                            <textarea id="description" name="description" rows="4" 
                                class="textarea-field @error('description') border-red-500 @enderror" placeholder="Ceritakan tentang lapak Anda...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-neutral-700 mb-2">
                                Alamat Lapak
                            </label>
                            <textarea id="address" name="address" rows="3" 
                                class="textarea-field @error('address') border-red-500 @enderror" placeholder="Masukkan alamat lengkap lapak...">{{ old('address') }}</textarea>
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
                            <input id="bank_name" type="text" name="bank_name" value="{{ old('bank_name') }}" required
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
                            <input id="bank_account_number" type="text" name="bank_account_number" value="{{ old('bank_account_number') }}" required
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
                            <input id="bank_account_holder" type="text" name="bank_account_holder" value="{{ old('bank_account_holder') }}" required
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
                            Buat Lapak
                        </button>
                        <a href="{{ route('home') }}" class="btn-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
