@section('meta_description', $product->description
    ? strip_tags(Str::limit($product->description, 160))
    : 'Detail ' . e($product->name) . ' — Pesan sekarang via WhatsApp.')
@section('og_title', $product->name)
@section('og_description', $product->description ? strip_tags(Str::limit($product->description, 200)) : '')
@section('og_image', $product->display_image ? \Illuminate\Support\Facades\Storage::url($product->display_image) : '')
@section('og_type', 'product')
<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-rose-500">Home</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            @if($product->category)
                <a href="{{ route('products', ['category' => $product->category->slug]) }}" wire:navigate class="hover:text-rose-500">{{ $product->category->name }}</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            @endif
            <span class="text-gray-900 font-medium">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-14">

            {{-- ── Image Carousel ─────────────────────────────────── --}}
            @php $images = $this->carousel_images; @endphp

            <div
                x-data="{
                    current: 0,
                    images: {{ json_encode($images) }},
                    storageBase: '{{ rtrim(\Illuminate\Support\Facades\Storage::url(''), '/') }}',
                    autoplayInterval: null,
                    autoplayDelay: 8000,
                    lightboxOpen: false,
                    lightboxIndex: 0,
                    get currentImage() {
                        return this.images[this.current]?.image ?? null;
                    },
                    prev() {
                        this.current = this.current === 0 ? this.images.length - 1 : this.current - 1;
                        this.restartAutoplay();
                    },
                    next() {
                        this.current = this.current === this.images.length - 1 ? 0 : this.current + 1;
                        this.restartAutoplay();
                    },
                    goTo(i) {
                        this.current = i;
                        this.restartAutoplay();
                    },
                    goToVariant(variantId) {
                        if (variantId === null) {
                            this.current = 0;
                        } else {
                            let idx = this.images.findIndex(img => img.variantId == variantId);
                            if (idx >= 0) this.current = idx;
                        }
                        this.restartAutoplay();
                    },
                    startAutoplay() {
                        if (this.images.length <= 1) return;
                        this.autoplayInterval = setInterval(() => {
                            this.current = this.current === this.images.length - 1 ? 0 : this.current + 1;
                        }, this.autoplayDelay);
                    },
                    stopAutoplay() {
                        clearInterval(this.autoplayInterval);
                        this.autoplayInterval = null;
                    },
                    restartAutoplay() {
                        this.stopAutoplay();
                        this.startAutoplay();
                    },
                    openLightbox(i) {
                        this.lightboxIndex = i;
                        this.lightboxOpen = true;
                        this.stopAutoplay();
                        document.body.style.overflow = 'hidden';
                    },
                    closeLightbox() {
                        this.lightboxOpen = false;
                        this.startAutoplay();
                        document.body.style.overflow = '';
                    },
                    lightboxPrev() {
                        this.lightboxIndex = this.lightboxIndex === 0 ? this.images.length - 1 : this.lightboxIndex - 1;
                    },
                    lightboxNext() {
                        this.lightboxIndex = this.lightboxIndex === this.images.length - 1 ? 0 : this.lightboxIndex + 1;
                    }
                }"
                x-init="startAutoplay()"
                x-on:variant-changed.window="goToVariant($event.detail.variantId)"
            >
                {{-- Main image --}}
                <div
                    class="relative aspect-square bg-gray-50 rounded-2xl overflow-hidden"
                    @mouseenter="stopAutoplay()"
                    @mouseleave="startAutoplay()"
                >
                    <template x-if="currentImage">
                        <img
                            :key="current"
                            :src="storageBase + '/' + currentImage"
                            class="w-full h-full object-contain p-4 transition-opacity duration-500 cursor-zoom-in"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 scale-105"
                            x-transition:enter-end="opacity-100 scale-100"
                            :alt="'{{ $product->name }}'"
                            @click="openLightbox(current)"
                        >
                    </template>
                    <template x-if="!currentImage">
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </template>

                    {{-- Prev / Next arrows --}}
                    <template x-if="images.length > 1">
                        <div>
                            <button
                                @click="prev"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 bg-white/80 hover:bg-white rounded-full shadow flex items-center justify-center transition"
                            >
                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button
                                @click="next"
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 bg-white/80 hover:bg-white rounded-full shadow flex items-center justify-center transition"
                            >
                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </template>

                    {{-- Dot indicators --}}
                    <template x-if="images.length > 1">
                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5">
                            <template x-for="(img, i) in images" :key="i">
                                <button
                                    @click="goTo(i)"
                                    class="w-2 h-2 rounded-full transition"
                                    :class="current === i ? 'bg-rose-500 w-4' : 'bg-white/70 hover:bg-white'"
                                ></button>
                            </template>
                        </div>
                    </template>
                </div>

                {{-- Thumbnail strip --}}
                @if(count($images) > 1)
                    <div class="mt-3 flex gap-2 overflow-x-auto pb-1">
                        <template x-for="(img, i) in images" :key="i">
                            <button
                                @click="goTo(i); openLightbox(i)"
                                class="shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 transition"
                                :class="current === i ? 'border-rose-500' : 'border-transparent hover:border-rose-200'"
                            >
                                <template x-if="img.image">
                                    <img :src="storageBase + '/' + img.image" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!img.image">
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </template>
                            </button>
                        </template>
                    </div>
                @endif
                {{-- Lightbox overlay --}}
                <template x-if="lightboxOpen">
                    <div
                        class="fixed inset-0 z-[100] bg-black/90 flex items-center justify-center"
                        @click.self="closeLightbox"
                        @keydown.escape.window="closeLightbox"
                    >
                        <button @click="closeLightbox" class="absolute top-4 right-4 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition z-10">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>

                        <template x-if="images.length > 1">
                            <button @click="lightboxPrev" class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition z-10">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                        </template>

                        <img
                            :key="lightboxIndex"
                            :src="storageBase + '/' + images[lightboxIndex]?.image"
                            class="max-w-[90vw] max-h-[85vh] object-contain select-none"
                        >

                        <template x-if="images.length > 1">
                            <button @click="lightboxNext" class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition z-10">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </template>

                        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/70 text-sm font-medium bg-black/30 px-3 py-1.5 rounded-full" x-text="(lightboxIndex + 1) + ' / ' + images.length"></div>
                    </div>
                </template>
            </div>

            {{-- ── Product Info + Order Form ───────────────────────── --}}
            <div>
                @if($product->category)
                    <div class="text-sm text-rose-500 font-medium">{{ $product->category->name }}</div>
                @endif
                <h1 class="mt-1 text-3xl font-bold text-gray-900">{{ $product->name }}</h1>

                {{-- ── Harga & Deskripsi (reaktif berdasarkan varian dipilih) ── --}}
                @php
                    $hasVariants = $product->variants->isNotEmpty();
                    $selVariant  = $this->selected_variant;   // null jika tidak ada yang dipilih
                    $activePrice = $this->active_price;
                    $activeDesc  = $this->active_description;
                    $isVariantActive = $selVariant !== null;
                @endphp

                {{-- Harga --}}
                <div class="mt-4">
                    @if($activePrice)
                        <p class="text-3xl font-bold text-rose-500">
                            Rp {{ number_format((float) $activePrice, 0, ',', '.') }}
                        </p>
                    @else
                        <p class="text-sm text-gray-400 italic">Hubungi kami untuk harga</p>
                    @endif

                    @if($hasVariants && !$isVariantActive && $product->variants->count() > 1)
                        @php $minP = $product->variants->whereNotNull('price')->min('price') ?? $product->price; @endphp
                        <p class="text-xs text-gray-400 mt-1">
                            Mulai Rp {{ number_format((float) $minP, 0, ',', '.') }}
                            &mdash; pilih varian di bawah untuk harga pasti
                        </p>
                    @endif
                </div>

                {{-- Deskripsi — label berubah sesuai kondisi --}}
                @if($activeDesc)
                    <div class="mt-5">
                        <h3 class="text-sm font-semibold text-gray-700 mb-1.5">
                            @if($isVariantActive && $selVariant->description)
                                Detail Varian
                            @else
                                Deskripsi Produk
                            @endif
                        </h3>
                        <div class="text-sm text-gray-600 leading-relaxed">
                            {!! nl2br(e($activeDesc)) !!}
                        </div>
                    </div>
                @endif

                {{-- Variants selector --}}
                @if($hasVariants)
                    <div class="mt-6">
                        <p class="text-sm font-semibold text-gray-700 mb-3">Pilih Varian:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->variants as $variant)
                                @php $isActive = $selectedVariantId === $variant->id; @endphp
                                <button
                                    wire:click="selectVariant({{ $variant->id }})"
                                    class="px-4 py-2.5 rounded-xl border-2 text-sm font-medium transition-all text-left
                                        {{ $isActive
                                            ? 'border-rose-500 bg-rose-50 text-rose-700 shadow-sm shadow-rose-100'
                                            : 'border-gray-200 text-gray-600 hover:border-rose-300 hover:text-rose-600' }}"
                                >
                                    {{-- Nama varian sebagai label utama --}}
                                    @if($variant->name)
                                        {{ $variant->name }}
                                    @elseif($variant->description)
                                        {{ Str::limit($variant->description, 30) }}
                                    @else
                                        Varian {{ $loop->iteration }}
                                    @endif

                                    {{-- Harga --}}
                                    <span class="block text-xs mt-0.5 font-semibold {{ $isActive ? 'text-rose-500' : 'text-gray-400' }}">
                                        Rp {{ number_format((float) ($variant->price ?? $product->price), 0, ',', '.') }}
                                    </span>
                                </button>
                            @endforeach
                        </div>
                        @if(!$isVariantActive)
                            <p class="mt-2 text-xs text-gray-400">
                                Klik varian untuk melihat detail. Klik lagi untuk kembali ke info dasar.
                            </p>
                        @endif
                    </div>
                @endif

                {{-- Order Form --}}
                <div class="mt-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                    <h2 class="text-base font-semibold text-gray-900 mb-4">Form Pemesanan</h2>
                    <form wire:submit="submitOrder" class="space-y-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemesan <span class="text-red-500">*</span></label>
                            <p class="text-xs text-gray-400 mb-1.5">Nama Anda sebagai pemesan dan pengirim</p>
                            <input type="text" wire:model="customerName" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                            @error('customerName') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima <span class="text-red-500">*</span></label>
                            <p class="text-xs text-gray-400 mb-1.5">Nama orang yang akan menerima bunga ini</p>
                            <input type="text" wire:model="recipientName" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                            @error('recipientName') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Tujuan <span class="text-red-500">*</span></label>
                            <p class="text-xs text-gray-400 mb-1.5">Lokasi lengkap pengiriman bunga (nama jalan, gedung, kota, dll)</p>
                            <textarea wire:model="deliveryAddress" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"></textarea>
                            @error('deliveryAddress') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kirim <span class="text-red-500">*</span></label>
                            <p class="text-xs text-gray-400 mb-1.5">Pilih tanggal kapan bunga akan dikirimkan</p>
                            <input type="date" wire:model="deliveryDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                            @error('deliveryDate') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ucapan <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <p class="text-xs text-gray-400 mb-1.5">Teks yang akan disertakan pada bunga, misalnya "Selamat Ulang Tahun"</p>
                            <textarea wire:model="greetingMessage" rows="2" placeholder="Tulis ucapan yang ingin disertakan..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <p class="text-xs text-gray-400 mb-1.5">Informasi tambahan untuk penjual (misal: warna, ukuran, permintaan khusus)</p>
                            <textarea wire:model="notes" rows="2" placeholder="Contoh: bungkus warna merah, tambah pita" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"></textarea>
                        </div>

                        {{-- Payment Methods --}}
                        @php
                            $paymentMethods = json_decode(\App\Models\Setting::get('payment_methods', '[]'), true) ?: [];
                        @endphp
                        @if(!empty($paymentMethods))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pembayaran <span class="text-gray-400 font-normal">(opsional)</span></label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($paymentMethods as $pm)
                                        <button
                                            type="button"
                                            wire:click="selectPaymentMethod('{{ addslashes($pm['name']) }}')"
                                            class="flex items-center justify-center p-3 rounded-xl border-2 transition-all
                                                {{ $selectedPaymentMethod === $pm['name']
                                                    ? 'border-rose-500 bg-rose-50 shadow-sm shadow-rose-100'
                                                    : 'border-gray-200 bg-white hover:border-rose-300' }}"
                                        >
                                            @if($pm['logo'])
                                                <img src="{{ Storage::url($pm['logo']) }}" alt="{{ $pm['name'] }}" class="h-10 w-auto object-contain">
                                            @endif
                                            @if($selectedPaymentMethod === $pm['name'])
                                                <svg class="w-4 h-4 text-rose-500 -ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <button
                            type="submit"
                            class="w-full py-3 bg-green-500 text-white font-medium rounded-xl hover:bg-green-600 transition shadow-lg shadow-green-100 flex items-center justify-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Pesan via WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->isNotEmpty())
            <section class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900">Produk Terkait</h2>
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($relatedProducts as $related)
                        @php $relImg = $related->display_image; @endphp
                        <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:shadow-rose-50 hover:-translate-y-0.5 transition-all duration-300 flex flex-col">
                            <a href="{{ route('product.show', $related->slug) }}" wire:navigate class="block relative aspect-square bg-gray-50 overflow-hidden">
                                @if($relImg)
                                    <img src="{{ Storage::url($relImg) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-14 h-14 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif

                                <div class="absolute top-2 left-2 z-10">
                                    <span class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-rose-600 text-[11px] font-semibold rounded-full shadow-sm">
                                        {{ $related->category?->name }}
                                    </span>
                                </div>

                                @if($related->variants->count() > 1)
                                    <div class="absolute top-2 right-2 z-10">
                                        <span class="px-2 py-0.5 bg-black/40 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                                            {{ $related->variants->count() }} varian
                                        </span>
                                    </div>
                                @endif
                            </a>

                            <a href="{{ route('product.show', $related->slug) }}" wire:navigate class="block p-4 flex-1">
                                <h3 class="font-semibold text-gray-900 group-hover:text-rose-600 transition line-clamp-2">{{ $related->name }}</h3>
                                @if($related->starting_price)
                                    <p class="mt-1.5 text-base font-bold text-gray-900">
                                        @if($related->variants->count() > 1)
                                            <span class="text-xs font-normal text-gray-400 mr-0.5">Mulai</span>
                                        @endif
                                        Rp {{ number_format((float) $related->starting_price, 0, ',', '.') }}
                                    </p>
                                @else
                                    <p class="mt-1.5 text-xs text-gray-400">Hubungi untuk harga</p>
                                @endif
                            </a>

                            <div class="px-4 pb-4 pt-0">
                                <a href="{{ route('product.show', $related->slug) }}" wire:navigate class="block w-full text-center py-2.5 bg-rose-50 text-rose-600 text-sm font-medium rounded-xl hover:bg-rose-100 hover:text-rose-700 active:bg-rose-200 transition-all">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>
