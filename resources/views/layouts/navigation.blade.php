<nav x-data="{ open: false }" class="bg-white border-b border-neutral-100 shadow-soft sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::check() ? route(Auth::user()->role . '.dashboard') : route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center shadow-soft group-hover:shadow-soft-lg transition-all duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-neutral-900 hidden md:block">Marketplace</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-neutral-700 hover:text-primary-600 hover:bg-neutral-50 rounded-lg transition-all duration-200 {{ request()->routeIs('home') || request()->routeIs('products.*') ? 'text-primary-600 bg-primary-50' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Beranda
                    </a>
                    
                    @auth
                        <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-neutral-700 hover:text-primary-600 hover:bg-neutral-50 rounded-lg transition-all duration-200 {{ request()->routeIs(Auth::user()->role . '.dashboard') ? 'text-primary-600 bg-primary-50' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Dashboard
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                @auth
                    <!-- Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="relative inline-flex items-center justify-center w-10 h-10 text-neutral-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg focus:outline-none transition-all duration-200 {{ request()->routeIs('cart.*') ? 'text-primary-600 bg-primary-50' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        @php
                            $cartCount = Auth::user()->cartItems()->count();
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- User Dropdown -->
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-3 py-2 border border-neutral-200 text-sm leading-4 font-medium rounded-lg text-neutral-700 bg-white hover:bg-neutral-50 hover:border-neutral-300 focus:outline-none transition-all duration-200">
                                <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-semibold text-xs">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <div class="font-semibold text-neutral-900">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-neutral-500 capitalize">{{ Auth::user()->role }}</div>
                                </div>
                                <svg class="fill-current h-4 w-4 text-neutral-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Profile Section -->
                            <div class="px-4 py-3 border-b border-neutral-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-neutral-900">{{ Auth::user()->name }}</div>
                                        <div class="text-sm text-neutral-500">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Link -->
                            <x-dropdown-link :href="route('profile.edit')">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-neutral-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ __('Profil Saya') }}</span>
                                </div>
                            </x-dropdown-link>

                            <div class="border-t border-neutral-100 my-2"></div>

                            <!-- Role-Specific Links -->
                            @if(Auth::user()->role === 'buyer')
                                <div class="px-3 py-2">
                                    <div class="text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Belanja</div>
                                </div>
                                
                                <x-dropdown-link :href="route('buyer.orders.index')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">{{ __('Pesanan Saya') }}</span>
                                    </div>
                                </x-dropdown-link>

                                <div class="border-t border-neutral-100 my-2"></div>

                                <x-dropdown-link :href="route('shop.create')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ __('Buka Lapak') }}</div>
                                            <div class="text-xs text-neutral-500">Mulai berjualan sekarang</div>
                                        </div>
                                    </div>
                                </x-dropdown-link>
                            @endif

                            @if(Auth::user()->role === 'seller')
                                <div class="px-3 py-2">
                                    <div class="text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Lapak Saya</div>
                                </div>

                                <x-dropdown-link :href="route('seller.products.index')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">{{ __('Produk Saya') }}</span>
                                    </div>
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('seller.orders.index')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">{{ __('Pesanan Masuk') }}</span>
                                    </div>
                                </x-dropdown-link>
                            @endif

                            @if(Auth::user()->role === 'admin')
                                <div class="px-3 py-2">
                                    <div class="text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-2">Admin</div>
                                </div>

                                <x-dropdown-link :href="route('admin.dashboard')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">{{ __('Dashboard Admin') }}</span>
                                    </div>
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.users.index')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">{{ __('Kelola User') }}</span>
                                    </div>
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-neutral-100 my-2"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    <div class="flex items-center gap-3 text-red-600">
                                        <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">{{ __('Keluar') }}</span>
                                    </div>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Guest CTA Buttons -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-neutral-700 hover:text-primary-600 transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                @auth
                    <a href="{{ route('cart.index') }}" class="relative inline-flex items-center justify-center mr-2 p-2 text-neutral-600 hover:text-primary-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        @php
                            $cartCount = Auth::user()->cartItems()->count();
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endauth
                
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-neutral-100">
        @auth
            <!-- User Info -->
            <div class="px-4 py-4 border-b border-neutral-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="font-semibold text-neutral-900">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-neutral-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="py-2 space-y-1">
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home') || request()->routeIs('products.*')">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        {{ __('Beranda') }}
                    </div>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route(Auth::user()->role . '.dashboard')" :active="request()->routeIs(Auth::user()->role . '.dashboard')">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ __('Dashboard') }}
                    </div>
                </x-responsive-nav-link>
            </div>

            <!-- Role-Specific Links -->
            <div class="border-t border-neutral-100 py-2 space-y-1">
                @if(Auth::user()->role === 'buyer')
                    <x-responsive-nav-link :href="route('buyer.orders.index')" :active="request()->routeIs('buyer.orders.*')">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            {{ __('Pesanan Saya') }}
                        </div>
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('shop.create')">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ __('Buka Lapak') }}
                        </div>
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->role === 'seller')
                    <x-responsive-nav-link :href="route('seller.products.index')" :active="request()->routeIs('seller.products.*')">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            {{ __('Produk Saya') }}
                        </div>
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('seller.orders.index')" :active="request()->routeIs('seller.orders.*')">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            {{ __('Pesanan Masuk') }}
                        </div>
                    </x-responsive-nav-link>
                @endif
            </div>

            <!-- Profile & Logout -->
            <div class="border-t border-neutral-100 py-2 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('Profil Saya') }}
                    </div>
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        <div class="flex items-center gap-3 text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('Keluar') }}
                        </div>
                    </x-responsive-nav-link>
                </form>
            </div>
        @else
            <!-- Guest Links -->
            <div class="py-4 px-4 space-y-3">
                <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 bg-neutral-100 text-neutral-900 font-semibold rounded-lg hover:bg-neutral-200 transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="block w-full text-center btn-primary">
                    Daftar Sekarang
                </a>
            </div>
        @endauth
    </div>
</nav>
