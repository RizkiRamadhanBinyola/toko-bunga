@section('meta_description', $category->name . ' — Temukan berbagai pilihan ' . e($category->name) . ' untuk acara Anda.')
<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-rose-500">Home</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900">{{ $category->name }}</span>
        </nav>

        <div class="mt-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
            @if($category->description)
                <p class="mt-2 text-gray-500">{{ $category->description }}</p>
            @endif
        </div>

        @if($category->children->isNotEmpty())
            <div class="mt-6 flex flex-wrap gap-2">
                <a href="{{ route('category.show', $category->slug) }}" wire:navigate class="px-4 py-2 text-sm font-medium rounded-lg bg-rose-500 text-white">Semua</a>
                @foreach($category->children as $child)
                    <a href="{{ route('category.show', $child->slug) }}" wire:navigate class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-600 hover:bg-rose-50 hover:text-rose-600 transition">{{ $child->name }}</a>
                @endforeach
            </div>
        @endif

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @forelse($products as $product)
                @php $img = $product->display_image; @endphp
                <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:shadow-rose-50 hover:-translate-y-0.5 transition-all duration-300 flex flex-col">
                    <a href="{{ route('product.show', $product->slug) }}" wire:navigate class="block relative aspect-square bg-gray-50 overflow-hidden">
                        @if($img)
                            <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-14 h-14 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif

                        {{-- Category badge overlay --}}
                        <div class="absolute top-2 left-2 z-10">
                            <span class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-rose-600 text-[11px] font-semibold rounded-full shadow-sm">
                                {{ $product->category?->name }}
                            </span>
                        </div>

                        {{-- Variant count badge --}}
                        @if($product->variants->count() > 1)
                            <div class="absolute top-2 right-2 z-10">
                                <span class="px-2 py-0.5 bg-black/40 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                                    {{ $product->variants->count() }} varian
                                </span>
                            </div>
                        @endif
                    </a>

                    <a href="{{ route('product.show', $product->slug) }}" wire:navigate class="block p-4 flex-1">
                        <h3 class="font-semibold text-gray-900 group-hover:text-rose-600 transition line-clamp-2">
                            {{ $product->name }}
                        </h3>
                        @if($product->starting_price)
                            <p class="mt-1.5 text-base font-bold text-gray-900">
                                @if($product->variants->count() > 1)
                                    <span class="text-xs font-normal text-gray-400 mr-0.5">Mulai</span>
                                @endif
                                Rp {{ number_format((float) $product->starting_price, 0, ',', '.') }}
                            </p>
                        @else
                            <p class="mt-1.5 text-xs text-gray-400">Hubungi untuk harga</p>
                        @endif
                    </a>

                    <div class="px-4 pb-4 pt-0">
                        <a href="{{ route('product.show', $product->slug) }}" wire:navigate class="block w-full text-center py-2.5 bg-rose-50 text-rose-600 text-sm font-medium rounded-xl hover:bg-rose-100 hover:text-rose-700 active:bg-rose-200 transition-all">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg class="mx-auto w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <p class="mt-4 text-gray-400">Belum ada produk di kategori ini.</p>
                    <a href="{{ route('home') }}" wire:navigate class="mt-4 inline-flex text-sm text-rose-500 hover:text-rose-600">Kembali ke Beranda</a>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
