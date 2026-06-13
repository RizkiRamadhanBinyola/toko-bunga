<div>
    <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>

    @if(session('message'))
        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-rose-50 rounded-lg">
                    <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Kategori</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalCategories }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-50 rounded-lg">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Produk</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-amber-50 rounded-lg">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Active</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalProducts + $totalCategories }} Items</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900">Aksi Cepat</h2>
            <div class="mt-4 space-y-3">
                <a href="{{ route('admin.categories') }}" wire:navigate class="flex items-center justify-between p-4 bg-rose-50 rounded-lg hover:bg-rose-100 transition">
                    <span class="text-sm font-medium text-rose-700">Kelola Kategori</span>
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.products') }}" wire:navigate class="flex items-center justify-between p-4 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition">
                    <span class="text-sm font-medium text-emerald-700">Kelola Produk</span>
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.settings') }}" wire:navigate class="flex items-center justify-between p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <span class="text-sm font-medium text-blue-700">Pengaturan Toko</span>
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 pt-6 pb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Produk Terbaru</h2>
                @if($latestProducts->isNotEmpty())
                    <a href="{{ route('admin.products') }}" wire:navigate
                       class="text-sm text-rose-500 hover:text-rose-700 font-medium flex items-center gap-1">
                        Lihat semua
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif
            </div>
            @if($latestProducts->isEmpty())
                <p class="px-6 pb-6 text-sm text-gray-400">Belum ada produk.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[360px]">
                        <thead>
                            <tr class="border-y border-gray-100 bg-gray-50/50">
                                <th class="text-left px-6 py-2.5 text-xs font-medium text-gray-400 uppercase tracking-wider whitespace-nowrap">Produk</th>
                                <th class="text-left px-6 py-2.5 text-xs font-medium text-gray-400 uppercase tracking-wider whitespace-nowrap">Kategori</th>
                                <th class="text-right px-6 py-2.5 text-xs font-medium text-gray-400 uppercase tracking-wider whitespace-nowrap">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($latestProducts as $product)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-3">
                                        <p class="text-sm font-medium text-gray-900 truncate max-w-40">{{ $product->name }}</p>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <p class="text-xs text-gray-500">{{ $product->category?->name ?? '—' }}</p>
                                    </td>
                                    <td class="px-6 py-3 text-right whitespace-nowrap">
                                        <span class="text-sm font-semibold text-gray-900">
                                            @if($product->starting_price)
                                                Rp {{ number_format((float) $product->starting_price, 0, ',', '.') }}
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- Recent Activity Log --}}
    <div class="mt-8 bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 pt-6 pb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Aktivitas Admin</h2>
            <div class="flex items-center gap-2">
                <form action="{{ route('admin.logs.export') }}" method="GET" class="flex items-center gap-2">
                    <select name="months" class="text-xs border border-gray-200 rounded-lg px-2 py-1.5 text-gray-600 focus:outline-none focus:ring-1 focus:ring-rose-400">
                        <option value="1">1 bulan</option>
                        <option value="3" selected>3 bulan</option>
                        <option value="6">6 bulan</option>
                        <option value="12">12 bulan</option>
                        <option value="0">Semua</option>
                    </select>
                    <button type="submit" class="inline-flex items-center gap-1 text-xs font-medium text-white bg-rose-500 hover:bg-rose-600 px-3 py-1.5 rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Excel
                    </button>
                </form>
            </div>
        </div>
        @if($recentLogs->isEmpty())
            <p class="px-6 pb-6 text-sm text-gray-400">Belum ada aktivitas.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[400px]">
                    <thead>
                        <tr class="border-y border-gray-100 bg-gray-50/50">
                            <th class="text-left px-6 py-2.5 text-xs font-medium text-gray-400 uppercase tracking-wider whitespace-nowrap">Waktu</th>
                            <th class="text-left px-6 py-2.5 text-xs font-medium text-gray-400 uppercase tracking-wider whitespace-nowrap">Admin</th>
                            <th class="text-left px-6 py-2.5 text-xs font-medium text-gray-400 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                            <th class="text-left px-6 py-2.5 text-xs font-medium text-gray-400 uppercase tracking-wider whitespace-nowrap">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentLogs as $log)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ $log->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                    {{ $log->user?->name ?? '—' }}
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $log->action === 'login' ? 'bg-green-50 text-green-700' : '' }}
                                        {{ $log->action === 'logout' ? 'bg-gray-50 text-gray-600' : '' }}
                                        {{ !in_array($log->action, ['login', 'logout']) ? 'bg-blue-50 text-blue-700' : '' }}">
                                        {{ $log->action }}
                                    </span>
                                    @if($log->description)
                                        <span class="text-xs text-gray-400 ml-1">{{ $log->description }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-400 font-mono">
                                    {{ $log->ip_address ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
