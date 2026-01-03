<x-app-layout>
    <!-- Page Header -->
    <div class="bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-900">Kelola User</h1>
                        <p class="text-neutral-600">Manajemen pengguna dan hak akses</p>
                    </div>
                </div>
                <a href="{{ route('admin.users.create') }}" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah User
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

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Search & Filter -->
            <div class="card mb-6">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="input-field">
                    </div>
                    <div class="w-full md:w-48">
                        <select name="role" class="select-field">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="seller" {{ request('role') === 'seller' ? 'selected' : '' }}>Seller</option>
                            <option value="buyer" {{ request('role') === 'buyer' ? 'selected' : '' }}>Buyer</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                    @if(request('search') || request('role'))
                        <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Role Filter Tabs -->
            <div class="mb-6 bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <div class="flex min-w-full">
                        <a href="{{ route('admin.users.index') }}" class="flex-1 px-4 py-4 text-center text-sm font-medium transition-all duration-200 border-b-2 {{ !request('role') ? 'border-primary-600 text-primary-600 bg-primary-50' : 'border-transparent text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                            <div class="flex flex-col items-center gap-1">
                                <span>Semua User</span>
                                <span class="badge badge-neutral text-xs">{{ $roleCounts['all'] }}</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="flex-1 px-4 py-4 text-center text-sm font-medium transition-all duration-200 border-b-2 {{ request('role') === 'admin' ? 'border-red-600 text-red-600 bg-red-50' : 'border-transparent text-neutral-600 hover:text-red-600 hover:bg-neutral-50' }}">
                            <div class="flex flex-col items-center gap-1">
                                <span>Admin</span>
                                <span class="badge badge-danger text-xs">{{ $roleCounts['admin'] }}</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.users.index', ['role' => 'seller']) }}" class="flex-1 px-4 py-4 text-center text-sm font-medium transition-all duration-200 border-b-2 {{ request('role') === 'seller' ? 'border-green-600 text-green-600 bg-green-50' : 'border-transparent text-neutral-600 hover:text-green-600 hover:bg-neutral-50' }}">
                            <div class="flex flex-col items-center gap-1">
                                <span>Seller</span>
                                <span class="badge badge-success text-xs">{{ $roleCounts['seller'] }}</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.users.index', ['role' => 'buyer']) }}" class="flex-1 px-4 py-4 text-center text-sm font-medium transition-all duration-200 border-b-2 {{ request('role') === 'buyer' ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-neutral-600 hover:text-blue-600 hover:bg-neutral-50' }}">
                            <div class="flex flex-col items-center gap-1">
                                <span>Buyer</span>
                                <span class="badge badge-primary text-xs">{{ $roleCounts['buyer'] }}</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            @if($users->count() > 0)
                <!-- Users Table -->
                <div class="card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-neutral-200">
                            <thead class="bg-neutral-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Terdaftar</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-neutral-200">
                                @foreach($users as $user)
                                    <tr class="hover:bg-neutral-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center text-white font-semibold">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-neutral-900">{{ $user->name }}</div>
                                                    @if($user->id === auth()->id())
                                                        <span class="text-xs text-primary-600">(Anda)</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-neutral-900">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $roleConfig = [
                                                    'admin' => ['class' => 'badge-danger', 'label' => 'Admin'],
                                                    'seller' => ['class' => 'badge-success', 'label' => 'Seller'],
                                                    'buyer' => ['class' => 'badge-primary', 'label' => 'Buyer'],
                                                ];
                                                $config = $roleConfig[$user->role] ?? ['class' => 'badge-neutral', 'label' => ucfirst($user->role)];
                                            @endphp
                                            <span class="badge {{ $config['class'] }}">{{ $config['label'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                            {{ $user->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="text-primary-600 hover:text-primary-700">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-700">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="card text-center py-16">
                    <div class="flex flex-col items-center gap-6">
                        <div class="w-24 h-24 bg-neutral-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-neutral-900 mb-2">Tidak Ada User</h3>
                            <p class="text-neutral-500">Belum ada user yang terdaftar.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
