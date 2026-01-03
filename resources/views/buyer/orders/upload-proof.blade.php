<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload Payment Proof') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Order Information -->
                    <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl font-bold mb-2">{{ $order->invoice_number }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Order Total: <strong class="text-lg text-indigo-600 dark:text-indigo-400">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                    </div>

                    <!-- Bank Account Details -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-lg mb-3">Transfer to this Account:</h4>
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg border border-blue-200 dark:border-blue-700">
                            <p class="text-sm mb-2"><strong>Shop:</strong> {{ $order->shop->name }}</p>
                            <p class="text-sm mb-2"><strong>Bank:</strong> {{ $order->shop->bank_name }}</p>
                            <p class="text-sm mb-2"><strong>Account Number:</strong> 
                                <span class="text-lg font-mono font-bold">{{ $order->shop->bank_account_number }}</span>
                            </p>
                            <p class="text-sm"><strong>Account Holder:</strong> {{ $order->shop->bank_account_holder }}</p>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Please make sure to transfer the exact amount: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>

                    <!-- Upload Form -->
                    <form method="POST" action="{{ route('buyer.orders.upload-proof', $order) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="payment_proof" :value="__('Upload Payment Proof')" />
                            <input id="payment_proof" class="block mt-1 w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none" type="file" name="payment_proof" accept="image/*" required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">PNG, JPG up to 2MB. Please upload a clear image of your transfer receipt.</p>
                            <x-input-error :messages="$errors->get('payment_proof')" class="mt-2" />
                        </div>

                        <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 p-4 rounded-lg">
                            <h5 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-2">Important:</h5>
                            <ul class="list-disc list-inside text-sm text-yellow-700 dark:text-yellow-300 space-y-1">
                                <li>Make sure the payment proof is clear and readable</li>
                                <li>The receipt should show the transfer amount and date</li>
                                <li>Your order status will change to "Waiting Verification" after upload</li>
                                <li>The seller will verify your payment and process your order</li>
                            </ul>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('buyer.orders.show', $order) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Upload Payment Proof') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
