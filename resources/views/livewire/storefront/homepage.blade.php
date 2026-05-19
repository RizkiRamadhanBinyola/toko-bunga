<div>
    {{-- Hero --}}
    <section class="relative bg-gradient-to-br from-rose-50 via-white to-amber-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
            <div class="max-w-2xl">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                    Bunga Papan<br>
                    <span class="text-rose-500">Terbaik untuk</span><br>
                    Momen Spesial
                </h1>
                <p class="mt-6 text-lg text-gray-600 leading-relaxed">
                    Kami menyediakan berbagai rangkaian bunga papan elegan untuk ucapan selamat, dukacita, grand opening, dan berbagai acara lainnya.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products') }}" wire:navigate class="inline-flex items-center justify-center px-6 py-3 bg-rose-500 text-white font-medium rounded-xl hover:bg-rose-600 transition shadow-lg shadow-rose-200">
                        Lihat Katalog
                    </a>
                    <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281234567890') }}" target="_blank" class="inline-flex items-center justify-center px-6 py-3 bg-white text-gray-700 font-medium rounded-xl border border-gray-200 hover:border-rose-200 hover:text-rose-500 transition">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Order via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    <section id="categories" class="py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900">Kategori Produk</h2>
                <p class="mt-2 text-gray-500">Pilih kategori bunga papan yang Anda butuhkan</p>
            </div>

            <div class="mt-10 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @forelse($categories as $cat)
                    <a href="{{ route('products', ['category' => $cat->slug]) }}" wire:navigate class="group p-6 bg-white rounded-xl border border-gray-100 hover:border-rose-200 hover:shadow-lg hover:shadow-rose-50 transition-all text-center">
                        <div class="w-12 h-12 mx-auto bg-rose-50 rounded-xl flex items-center justify-center group-hover:bg-rose-100 transition">
                            <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                        </div>
                        <h3 class="mt-3 text-sm font-medium text-gray-900 group-hover:text-rose-600 transition">{{ $cat->name }}</h3>
                        <p class="mt-1 text-xs text-gray-400">{{ $cat->children->count() > 0 ? $cat->children->count() . ' subkategori' : 'Lihat produk' }}</p>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-400">Belum ada kategori.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Latest Products --}}
    <section class="py-16 lg:py-24 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Produk Terbaru</h2>
                    <p class="mt-2 text-gray-500">Rangkaian bunga papan pilihan untuk Anda</p>
                </div>
                <a href="{{ route('products') }}" wire:navigate class="hidden sm:inline-flex items-center gap-1 text-sm font-medium text-rose-500 hover:text-rose-600">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @forelse($latestProducts as $product)
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

                            <div class="absolute top-2 left-2 z-10">
                                <span class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-rose-600 text-[11px] font-semibold rounded-full shadow-sm">
                                    {{ $product->category?->name }}
                                </span>
                            </div>

                            @if($product->variants->count() > 1)
                                <div class="absolute top-2 right-2 z-10">
                                    <span class="px-2 py-0.5 bg-black/40 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                                        {{ $product->variants->count() }} varian
                                    </span>
                                </div>
                            @endif
                        </a>

                        <a href="{{ route('product.show', $product->slug) }}" wire:navigate class="block p-4 flex-1">
                            <h3 class="font-semibold text-gray-900 group-hover:text-rose-600 transition line-clamp-2">{{ $product->name }}</h3>
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
                    <p class="col-span-full text-center text-gray-400 py-12">Belum ada produk.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-rose-500 to-rose-600 rounded-2xl p-8 lg:p-12 text-center text-white">
                <h2 class="text-2xl lg:text-3xl font-bold">Pesan Sekarang</h2>
                <p class="mt-3 text-rose-100 max-w-lg mx-auto">Hubungi kami via WhatsApp untuk konsultasi dan pemesanan bunga papan</p>
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281234567890') }}" target="_blank" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-white text-rose-600 font-medium rounded-xl hover:bg-rose-50 transition shadow-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Hubungi WhatsApp
                </a>
            </div>
        </div>
    </section>
</div>
