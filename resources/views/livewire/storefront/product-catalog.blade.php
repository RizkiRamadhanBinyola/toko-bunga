@section('canonical_url', route('products'))
@section('meta_description', $activeCategory
    ? 'Temukan berbagai ' . e($activeCategory->name) . ' pilihan untuk berbagai acara Anda. Pesan sekarang!'
    : 'Temukan berbagai rangkaian bunga papan pilihan untuk berbagai acara Anda. Pesan sekarang!')
<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- ── Page Header ─────────────────────────────────────────── --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Semua Produk</h1>
            <p class="mt-1 text-gray-500">
                @if ($search || $categorySlug || $minPrice || $maxPrice)
                    Menampilkan hasil filter
                    @if ($activeCategory)
                        — <span class="text-rose-500 font-medium">{{ $activeCategory->name }}</span>
                    @endif
                @else
                    Temukan rangkaian bunga papan pilihan kami
                @endif
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- ── Sidebar Filter ───────────────────────────────────── --}}
            <aside x-data="{ open: false }" class="lg:w-64 shrink-0">
                {{-- Mobile toggle --}}
                <button @click="open = !open"
                    class="lg:hidden w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 mb-4">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                        </svg>
                        Filter Produk
                    </span>
                    <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Search di luar dropdown filter --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 mb-4 lg:mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Produk</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
                        </svg>
                        <input type="text" wire:model.live.debounce.400ms="search" placeholder="Nama produk..."
                            class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                        @if ($search)
                            <button wire:click="$set('search', '')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                <div x-show="open" x-transition class="lg:!block" style="display: none;"
                    :style="window.innerWidth >= 1024 ? 'display:block' : ''">
                    <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-6 lg:sticky lg:top-24">

                        {{-- Active filters badge --}}
                        @if ($search || $categorySlug || $minPrice || $maxPrice || $sort !== 'latest')
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Filter
                                    Aktif</span>
                                <button wire:click="clearFilters"
                                    class="text-xs text-rose-500 hover:text-rose-700 font-medium">Reset semua</button>
                            </div>
                        @endif

                        {{-- Kategori --}}
                        <div x-data="{ expandedCategory: null }">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Kategori</label>
                            <div class="space-y-1">
                                {{-- Semua Kategori --}}
                                <button wire:click="$set('categorySlug', '')"
                                    class="w-full text-left px-3 py-2 rounded-lg text-sm transition
                                        {{ $categorySlug === '' ? 'bg-rose-50 text-rose-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                    Semua Kategori
                                </button>

                                {{-- Root Kategori dengan Collapsible --}}
                                @foreach ($categories as $cat)
                                    @if ($cat->children->isNotEmpty())
                                        {{-- Header (Clickable + Expandable) --}}
                                        <div class="flex items-center">
                                            <button wire:click="$set('categorySlug', '{{ $cat->slug }}')"
                                                class="flex-1 text-left px-3 py-2 rounded-lg text-sm transition
                                                    {{ $categorySlug === $cat->slug ? 'bg-rose-50 text-rose-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                                {{ $cat->name }}
                                            </button>
                                            <button
                                                @click.stop="expandedCategory = expandedCategory === {{ $cat->id }} ? null : {{ $cat->id }}"
                                                class="px-2 py-2 text-gray-600 hover:text-gray-900 transition">
                                                <svg class="w-4 h-4 transition-transform"
                                                    :class="expandedCategory === {{ $cat->id }} ? 'rotate-180' : ''"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                        </div>

                                        {{-- Sub Kategori --}}
                                        <div x-show="expandedCategory === {{ $cat->id }}" x-transition
                                            class="pl-4 space-y-1 border-l-2 border-gray-200">
                                            @foreach ($cat->children as $child)
                                                <button wire:click="$set('categorySlug', '{{ $child->slug }}')"
                                                    class="w-full text-left px-3 py-2 rounded-lg text-sm transition
                                                        {{ $categorySlug === $child->slug ? 'bg-rose-50 text-rose-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                                    {{ $child->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    @else
                                        {{-- Kategori tanpa anak (standalone) --}}
                                        <button wire:click="$set('categorySlug', '{{ $cat->slug }}')"
                                            class="w-full text-left px-3 py-2 rounded-lg text-sm transition
                                                {{ $categorySlug === $cat->slug ? 'bg-rose-50 text-rose-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                            {{ $cat->name }}
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Rentang Harga</label>
                            <div class="space-y-2">
                                <div class="relative">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">Rp</span>
                                    <input type="number" wire:model.live.debounce.600ms="minPrice" placeholder="Min"
                                        min="0"
                                        class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                                </div>
                                <div class="relative">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">Rp</span>
                                    <input type="number" wire:model.live.debounce.600ms="maxPrice" placeholder="Max"
                                        min="0"
                                        class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                                </div>
                                @if ($minPrice || $maxPrice)
                                    <button wire:click="$set('minPrice', ''); $set('maxPrice', '')"
                                        class="text-xs text-rose-500 hover:text-rose-700">Hapus filter harga</button>
                                @endif
                            </div>
                        </div>

                        {{-- Urutkan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan</label>
                            <select wire:model.live="sort"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none appearance-none bg-white">
                                <option value="latest">Terbaru</option>
                                <option value="price_asc">Harga: Terendah</option>
                                <option value="price_desc">Harga: Tertinggi</option>
                                <option value="name_asc">Nama A–Z</option>
                            </select>
                        </div>

                    </div>
                </div>
            </aside>

            {{-- ── Product Grid ──────────────────────────────────────── --}}
            <div class="flex-1 min-w-0">

                {{-- Result count + active filter chips --}}
                <div class="flex flex-wrap items-center gap-2 mb-5">
                    <span class="text-sm text-gray-500">
                        <span class="font-semibold text-gray-900">{{ $products->total() }}</span> produk ditemukan
                    </span>

                    @if ($categorySlug && $activeCategory)
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 text-rose-600 text-xs font-medium rounded-full">
                            {{ $activeCategory->name }}
                            <button wire:click="$set('categorySlug', '')" class="hover:text-rose-800">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </span>
                    @endif
                    @if ($search)
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-blue-600 text-xs font-medium rounded-full">
                            "{{ $search }}"
                            <button wire:click="$set('search', '')" class="hover:text-blue-800">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </span>
                    @endif
                    @if ($minPrice || $maxPrice)
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-600 text-xs font-medium rounded-full">
                            Rp {{ $minPrice ? number_format((float) $minPrice, 0, ',', '.') : '0' }}
                            — {{ $maxPrice ? 'Rp ' . number_format((float) $maxPrice, 0, ',', '.') : '∞' }}
                            <button wire:click="$set('minPrice', ''); $set('maxPrice', '')"
                                class="hover:text-amber-800">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </span>
                    @endif
                </div>

                {{-- Loading overlay --}}
                <div wire:loading.delay class="text-center py-4">
                    <div class="inline-flex items-center gap-2 text-sm text-gray-500">
                        <svg class="animate-spin w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                        </svg>
                        Memuat produk...
                    </div>
                </div>

                {{-- Grid --}}
                <div wire:loading.class="opacity-50 pointer-events-none" class="transition-opacity duration-200">
                    @if ($products->isEmpty())
                        <div class="text-center py-20">
                            <svg class="mx-auto w-16 h-16 text-gray-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-4 text-gray-400 font-medium">Tidak ada produk ditemukan</p>
                            <p class="mt-1 text-sm text-gray-400">Coba ubah filter atau kata kunci pencarian</p>
                            <button wire:click="clearFilters"
                                class="mt-4 text-sm text-rose-500 hover:text-rose-700 font-medium">
                                Reset semua filter
                            </button>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                            @foreach ($products as $product)
                                @php
                                    $images = $product->variants->isNotEmpty()
                                        ? $product->variants
                                            ->map(fn($v) => $v->image ?: $product->thumbnail)
                                            ->filter()
                                            ->values()
                                            ->toArray()
                                        : ($product->thumbnail
                                            ? [$product->thumbnail]
                                            : []);
                                @endphp

                                <div
                                    class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:shadow-rose-50 hover:-translate-y-0.5 transition-all duration-300 flex flex-col">
                                    {{-- Image carousel per card --}}
                                    <a href="{{ route('product.show', $product->slug) }}" wire:navigate
                                        class="block relative aspect-square bg-gray-50 overflow-hidden">
                                        <div x-data="{
                                            current: 0,
                                            images: {{ json_encode($images) }},
                                            storageBase: '{{ rtrim(\Illuminate\Support\Facades\Storage::url(''), '/') }}',
                                            timer: null,
                                            start() {
                                                if (this.images.length <= 1) return;
                                                this.timer = setInterval(() => {
                                                    this.current = this.current === this.images.length - 1 ? 0 : this.current + 1;
                                                }, 8000);
                                            },
                                            stop() {
                                                clearInterval(this.timer);
                                                this.timer = null;
                                            }
                                        }" x-init="start()"
                                            class="relative w-full h-full" @mouseenter="stop()"
                                            @mouseleave="start()">
                                            @if (count($images) > 0)
                                                <template x-for="(img, i) in images" :key="i">
                                                    <div x-show="current === i"
                                                        x-transition:enter="transition ease-out duration-700"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="transition ease-in duration-300"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0" class="absolute inset-0">
                                                        <img :src="storageBase + '/' + img"
                                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                                            alt="{{ $product->name }}">
                                                    </div>
                                                </template>
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-14 h-14 text-gray-200" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif

                                            {{-- Dot indicators --}}
                                            @if (count($images) > 1)
                                                <div
                                                    class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1 z-10">
                                                    <template x-for="(img, i) in images" :key="i">
                                                        <div class="rounded-full transition-all duration-300"
                                                            :class="current === i ? 'w-4 h-1.5 bg-white' :
                                                                'w-1.5 h-1.5 bg-white/50'">
                                                        </div>
                                                    </template>
                                                </div>
                                            @endif

                                            {{-- Category badge overlay --}}
                                            <div class="absolute top-2 left-2 z-10">
                                                <span
                                                    class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-rose-600 text-[11px] font-semibold rounded-full shadow-sm">
                                                    {{ $product->category?->name }}
                                                </span>
                                            </div>

                                            {{-- Variant count badge --}}
                                            @if ($product->variants->count() > 1)
                                                <div class="absolute top-2 right-2 z-10">
                                                    <span
                                                        class="px-2 py-0.5 bg-black/40 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                                                        {{ $product->variants->count() }} varian
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </a>

                                    {{-- Card info --}}
                                    <a href="{{ route('product.show', $product->slug) }}" wire:navigate
                                        class="block p-4 flex-1">
                                        <h3
                                            class="font-semibold text-gray-900 group-hover:text-rose-600 transition line-clamp-2">
                                            {{ $product->name }}
                                        </h3>
                                        @if ($product->starting_price)
                                            <p class="mt-1.5 text-base font-bold text-gray-900">
                                                @if ($product->variants->count() > 1)
                                                    <span class="text-xs font-normal text-gray-400 mr-0.5">Mulai</span>
                                                @endif
                                                Rp {{ number_format((float) $product->starting_price, 0, ',', '.') }}
                                            </p>
                                        @else
                                            <p class="mt-1.5 text-xs text-gray-400">Hubungi untuk harga</p>
                                        @endif
                                    </a>

                                    {{-- CTA --}}
                                    <div class="px-4 pb-4 pt-0">
                                        <a href="{{ route('product.show', $product->slug) }}" wire:navigate
                                            class="block w-full text-center py-2.5 bg-rose-50 text-rose-600 text-sm font-medium rounded-xl hover:bg-rose-100 hover:text-rose-700 active:bg-rose-200 transition-all">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if ($products->hasPages())
                            <div class="mt-8">
                                {{ $products->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
