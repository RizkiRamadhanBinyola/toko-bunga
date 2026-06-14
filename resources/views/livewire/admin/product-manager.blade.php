<div>
    {{-- ── Header ──────────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-semibold text-gray-900">Produk</h1>
        <div class="flex items-center gap-3">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari produk..."
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none w-48"
            >
            <button
                wire:click="openCreate"
                class="px-4 py-2 text-sm font-medium text-white bg-rose-500 rounded-lg hover:bg-rose-600 transition"
            >
                + Tambah Produk
            </button>
        </div>
    </div>

    {{-- ── Table ───────────────────────────────────────────────────── --}}
    <div class="mt-6 bg-white rounded-xl border border-gray-200 overflow-hidden">
        @if($products->isEmpty())
            <div class="p-12 text-center">
                <svg class="mx-auto w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <p class="mt-4 text-sm text-gray-400">Belum ada produk. Klik "Tambah Produk" untuk membuat.</p>
            </div>
        @else
            {{-- Scroll hint mobile --}}
            <div class="sm:hidden flex items-center gap-1.5 px-4 py-2 bg-gray-50 border-b border-gray-100 text-xs text-gray-400">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
                Geser ke kanan untuk melihat semua kolom
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px]">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Produk</th>
                            <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Kategori</th>
                            <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Harga</th>
                            <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Varian</th>
                            <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                            <th class="text-right px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @php $img = $product->display_image; @endphp
                                        @if($img)
                                            <img src="{{ Storage::url($img) }}" class="w-10 h-10 rounded-lg object-cover shrink-0">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-rose-50 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate max-w-[160px]">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-400 truncate max-w-[160px]">{{ $product->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $product->category?->name ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->variants->count() > 0)
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700">
                                            {{ $product->variants->count() }} varian
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $product->status ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $product->status ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap space-x-2">
                                    <button wire:click="openEdit({{ $product->id }})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                                    <button
                                        x-on:click.prevent="
                                            Swal.fire({
                                                title: 'Hapus produk?',
                                                text: '{{ $product->name }} akan dihapus permanen.',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#e53e3e',
                                                cancelButtonColor: '#6b7280',
                                                confirmButtonText: 'Ya, hapus!',
                                                cancelButtonText: 'Batal',
                                            }).then((r) => r.isConfirmed && $wire.delete({{ $product->id }}));
                                        "
                                        class="text-sm text-red-500 hover:text-red-700 font-medium"
                                    >Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $products->links() }}
                </div>
            @endif
        @endif
    </div>

    {{-- ── Modal ───────────────────────────────────────────────────── --}}
    @if($showModal)
        <div
            class="fixed inset-0 z-50 flex items-start justify-center bg-black/40 overflow-y-auto px-4 py-6 sm:py-10"
            x-on:keydown.escape.window="$wire.closeModal()"
        >
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl mx-auto flex flex-col max-h-[calc(100dvh-3rem)] sm:max-h-[calc(100dvh-5rem)]">

                {{-- ── Modal Header (sticky) ── --}}
                <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-gray-100 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">
                                {{ $editId ? 'Edit Produk' : 'Tambah Produk' }}
                            </h2>
                            <p class="text-xs text-gray-400 mt-0.5">Lengkapi informasi produk di bawah ini</p>
                        </div>
                    </div>
                    <button wire:click="closeModal" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- ── Form (scrollable) ── --}}
                <form wire:submit="save" id="product-form" class="flex-1 overflow-y-auto px-5 py-5 space-y-6">

                    {{-- ══════════════════════════════════════════════════ --}}
                    {{-- SECTION: Informasi Produk                        --}}
                    {{-- ══════════════════════════════════════════════════ --}}
                    <div class="bg-rose-50/30 rounded-xl p-4 sm:p-5 space-y-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-rose-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-800">Informasi Produk</h3>
                                <p class="text-xs text-gray-400">Nama, kategori, dan status produk</p>
                            </div>
                        </div>

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nama Produk <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="name"
                                placeholder="Contoh: Bouquet Mawar Merah"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition-shadow"
                            >
                            @error('name') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                            {{-- Slug preview realtime via Alpine --}}
                            <p
                                x-data="{
                                    name: @entangle('name'),
                                    available: @entangle('slugAvailable'),
                                    get slug() {
                                        return (this.name || '')
                                            .toLowerCase()
                                            .normalize('NFD')
                                            .replace(/[\u0300-\u036f]/g, '')
                                            .replace(/[^a-z0-9\s-]/g, '')
                                            .trim()
                                            .replace(/[\s_]+/g, '-')
                                            .replace(/-+/g, '-');
                                    }
                                }"
                                class="mt-1.5 text-xs text-gray-400 flex items-center gap-1.5"
                            >
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                <span>
                                    URL produk:
                                    <span class="font-mono text-gray-500">/product/</span><span x-text="slug || '...'" class="font-mono text-rose-600"></span>
                                    <template x-if="available === false">
                                        <span class="ml-1.5 inline-flex items-center gap-0.5 text-red-500 font-medium">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                            Sudah dipakai
                                        </span>
                                    </template>
                                    <template x-if="available === true">
                                        <span class="ml-1.5 inline-flex items-center gap-0.5 text-green-500 font-medium">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            Tersedia
                                        </span>
                                    </template>
                                </span>
                            </p>
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="categoryId" class="appearance-none w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition-shadow">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $parent)
                                    <optgroup label="{{ $parent->name }}">
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                        @foreach($parent->children as $child)
                                            <option value="{{ $child->id }}">— {{ $child->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('categoryId') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Status Produk --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Produk</label>
                            <label class="relative inline-flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" wire:model="status" class="sr-only peer">
                                <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-rose-400 peer-focus:ring-2 peer-focus:ring-rose-500/30 transition-colors after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">
                                    <span x-data="{ active: $wire.entangle('status') }" x-text="active ? 'Aktif' : 'Nonaktif'"></span>
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════════════ --}}
                    {{-- SECTION: Harga & Media                            --}}
                    {{-- ══════════════════════════════════════════════════ --}}
                    <div class="bg-blue-50/30 rounded-xl p-4 sm:p-5 space-y-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-800">Harga & Foto</h3>
                                <p class="text-xs text-gray-400">Harga dasar dan foto utama produk</p>
                            </div>
                        </div>

                        {{-- Harga Dasar --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Harga Dasar (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative" x-data="{ raw: $wire.entangle('price') }">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 text-sm font-medium">Rp</span>
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    x-init="
                                        const r = (raw || '').split('.')[0].replace(/\D/g, '');
                                        $el.value = r !== '' ? parseInt(r, 10).toLocaleString('id-ID') : '';
                                    "
                                    @input="
                                        const n = $el.value.replace(/\D/g, '');
                                        $el.value = n ? parseInt(n, 10).toLocaleString('id-ID') : '';
                                        raw = n;
                                    "
                                    placeholder="150.000"
                                    class="w-full pl-10 pr-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition-shadow"
                                >
                            </div>
                            @error('price') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                            <p class="mt-1.5 text-xs text-gray-400 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Harga ini digunakan sebagai harga default jika produk tidak memiliki varian.
                            </p>
                        </div>

                        {{-- Gallery & Upload --}}
                        @php $productImgCount = count($images) + count($existingImages); @endphp
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-sm font-medium text-gray-700">Foto Produk</label>
                                <span class="text-xs {{ $productImgCount >= 3 ? 'text-red-500 font-semibold' : 'text-gray-400' }}">
                                    {{ $productImgCount }}/3 foto
                                </span>
                            </div>

                            {{-- Gallery product images only --}}
                            @if($productImgCount > 0)
                                <div class="flex flex-wrap gap-3 mb-4">
                                    @foreach($images as $idx => $img)
                                        <div class="relative group w-[calc(50%-0.375rem)] sm:w-24">
                                            <img src="{{ $img->temporaryUrl() }}" class="w-full aspect-square rounded-xl object-cover border-2 border-gray-200 shadow-sm cursor-zoom-in" onclick="window.dispatchEvent(new CustomEvent('lightbox-open', {detail:'{{ str_replace("'", "\\'", $img->temporaryUrl()) }}'}))">
                                            <button type="button" wire:click="removeImage({{ $idx }})" class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center shadow-md hover:bg-red-600 transition">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                            <span class="absolute bottom-1 left-1 text-[10px] bg-black/60 text-white px-1.5 py-0.5 rounded-md">Foto {{ $loop->iteration }}</span>
                                        </div>
                                    @endforeach
                                    @foreach($existingImages as $idx => $path)
                                        <div class="relative group w-[calc(50%-0.375rem)] sm:w-24">
                                            <img src="{{ Storage::url($path) }}" class="w-full aspect-square rounded-xl object-cover border-2 border-gray-200 shadow-sm cursor-zoom-in" onclick="window.dispatchEvent(new CustomEvent('lightbox-open', {detail:'{{ str_replace("'", "\\'", Storage::url($path)) }}'}))">
                                            <button type="button" wire:click="removeExistingImage({{ $idx }})" class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center shadow-md hover:bg-red-600 transition">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                            <span class="absolute bottom-1 left-1 text-[10px] bg-black/60 text-white px-1.5 py-0.5 rounded-md">Foto {{ $loop->iteration }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Upload area (multiple files) --}}
                            <div
                                x-data="{ dragging: false }"
                                x-on:dragover.prevent="dragging = true"
                                x-on:dragleave.prevent="dragging = false"
                                x-on:drop.prevent="
                                    dragging = false;
                                    if ($event.dataTransfer.files.length) {
                                        $wire.uploadMultiple('images', $event.dataTransfer.files);
                                    }
                                "
                                x-on:click="$refs.fileInput.click()"
                                :class="{ 'border-rose-500 bg-rose-50/80 scale-[1.01]': dragging }"
                                class="flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-200 rounded-xl py-4 px-3 cursor-pointer hover:border-rose-300 hover:bg-rose-50/50 transition-all"
                            >
                                <svg class="w-6 h-6 text-gray-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs text-gray-400">
                                    <span class="text-rose-500 font-medium">Klik untuk upload</span> atau seret foto di sini
                                </span>
                                <span class="text-xs text-gray-300 mt-0.5">PNG, JPG, WebP (max 2MB, maks 3 foto)</span>
                                <input type="file" wire:model="images" accept="image/*" multiple class="hidden" x-ref="fileInput">
                            </div>
                            @error('images') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                            @error('images.*') <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                            <div wire:loading wire:target="images" class="mt-2 flex items-center gap-2 text-xs text-rose-500">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                                </svg>
                                Mengupload foto...
                            </div>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════════════ --}}
                    {{-- SECTION: Deskripsi                                --}}
                    {{-- ══════════════════════════════════════════════════ --}}
                    <div class="bg-emerald-50/30 rounded-xl p-4 sm:p-5 space-y-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-800">Deskripsi</h3>
                                <p class="text-xs text-gray-400">Informasi lengkap tentang produk</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi Produk</label>
                            <textarea
                                wire:model="description"
                                rows="4"
                                placeholder="Jelaskan detail produk, bahan, ukuran, dan informasi penting lainnya..."
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none resize-none transition-shadow"
                            ></textarea>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════════════ --}}
                    {{-- SECTION: Varian                                   --}}
                    {{-- ══════════════════════════════════════════════════ --}}
                    <div class="bg-purple-50/30 rounded-xl p-4 sm:p-5 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-800">Varian <span class="text-gray-400 font-normal text-xs">(opsional)</span></h3>
                                    <p class="text-xs text-gray-400">Tambahkan varian jika produk punya pilihan ukuran/jenis berbeda</p>
                                </div>
                            </div>
                            <button
                                type="button"
                                wire:click="addVariant"
                                class="shrink-0 px-3 py-1.5 text-xs font-medium text-purple-600 bg-purple-100 rounded-lg hover:bg-purple-200 transition flex items-center gap-1.5"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Tambah
                            </button>
                        </div>

                        @if(count($variants) > 0)
                            <div class="space-y-3">
                                @foreach($variants as $i => $variant)
                                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden transition hover:border-purple-200 hover:shadow-sm">
                                        {{-- Variant header --}}
                                        <div class="flex items-center justify-between px-4 py-2.5 bg-gray-50 border-b border-gray-100">
                                            <div class="flex items-center gap-2">
                                                <span class="w-5 h-5 rounded-md bg-purple-100 text-purple-600 flex items-center justify-center text-xs font-bold">{{ $i + 1 }}</span>
                                                <span class="text-xs font-medium text-gray-600">
                                                    @if(!empty($variant['name']))
                                                        {{ $variant['name'] }}
                                                    @else
                                                        Varian {{ $i + 1 }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" wire:model="variants.{{ $i }}.status" class="sr-only peer">
                                                    <div class="w-8 h-5 bg-gray-200 rounded-full peer peer-checked:bg-purple-400 peer-focus:ring-2 peer-focus:ring-purple-500/30 transition-colors after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></div>
                                                    <span class="ml-2 text-xs {{ ($variant['status'] ?? true) ? 'text-green-600' : 'text-gray-400' }}">
                                                        {{ ($variant['status'] ?? true) ? 'Aktif' : 'Nonaktif' }}
                                                    </span>
                                                </label>
                                                <button
                                                    type="button"
                                                    wire:click="removeVariant({{ $i }})"
                                                    class="p-1 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition"
                                                    title="Hapus varian"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Variant body --}}
                                        <div class="p-4 space-y-3">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama Varian</label>
                                                    <input
                                                        type="text"
                                                        wire:model="variants.{{ $i }}.name"
                                                        placeholder="Contoh: Small, Medium, Large"
                                                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition-shadow"
                                                    >
                                                    @error("variants.{$i}.name") <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-600 mb-1">Harga (Rp)</label>
                                                    <div x-data="{ raw: $wire.entangle('variants.{{ $i }}.price') }">
                                                        <input
                                                            type="text"
                                                            inputmode="numeric"
                                                            x-init="
                                                                const r = (raw || '').split('.')[0].replace(/\D/g, '');
                                                                $el.value = r !== '' ? parseInt(r, 10).toLocaleString('id-ID') : '';
                                                            "
                                                            @input="
                                                                const n = $el.value.replace(/\D/g, '');
                                                                $el.value = n ? parseInt(n, 10).toLocaleString('id-ID') : '';
                                                                raw = n;
                                                            "
                                                            placeholder="Kosongkan = pakai harga dasar"
                                                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition-shadow"
                                                        >
                                                    </div>
                                                    @error("variants.{$i}.price") <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                <div>
                                                    @php $varImgCount = count($variant['images']) + count($variant['existingImages']); @endphp
                                                    <div class="flex items-center justify-between mb-1">
                                                        <label class="block text-xs font-medium text-gray-600">Foto Varian</label>
                                                        <span class="text-xs {{ $varImgCount >= 3 ? 'text-red-500 font-semibold' : 'text-gray-400' }}">
                                                            {{ $varImgCount }}/3 foto
                                                        </span>
                                                    </div>
                                                    {{-- Variant images gallery --}}
                                                    @if(count($variant['images']) > 0 || count($variant['existingImages']) > 0)
                                                        <div class="flex flex-wrap gap-2 mb-2">
                                                            @foreach($variant['images'] as $ii => $img)
                                                                 <div class="relative group">
                                                                      <img src="{{ $img->temporaryUrl() }}" class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg object-cover border border-gray-200 cursor-zoom-in" onclick="window.dispatchEvent(new CustomEvent('lightbox-open', {detail:'{{ str_replace("'", "\\'", $img->temporaryUrl()) }}'}))">
                                                                      <button type="button" wire:click="removeVariantImage({{ $i }}, {{ $ii }})" class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-red-500 text-white rounded-full flex items-center justify-center shadow hover:bg-red-600 transition">
                                                                          <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                                                      </button>
                                                                  </div>
                                                              @endforeach
                                                              @foreach($variant['existingImages'] as $ii => $path)
                                                                  <div class="relative group">
                                                                      <img src="{{ Storage::url($path) }}" class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg object-cover border border-gray-200 cursor-zoom-in" onclick="window.dispatchEvent(new CustomEvent('lightbox-open', {detail:'{{ str_replace("'", "\\'", Storage::url($path)) }}'}))">
                                                                     <button type="button" wire:click="removeVariantExistingImage({{ $i }}, {{ $ii }})" class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-red-500 text-white rounded-full flex items-center justify-center shadow hover:bg-red-600 transition">
                                                                         <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                                                     </button>
                                                                 </div>
                                                             @endforeach
                                                        </div>
                                                    @endif
                                                    <label
                                                        x-data="{ dragging: false }"
                                                        x-on:dragover.prevent="dragging = true"
                                                        x-on:dragleave.prevent="dragging = false"
                                                        x-on:drop.prevent="
                                                            dragging = false;
                                                            if ($event.dataTransfer.files.length) {
                                                                $wire.uploadMultiple('variants.{{ $i }}.images', $event.dataTransfer.files);
                                                            }
                                                        "
                                                        x-on:click="$refs.fileInput.click()"
                                                        :class="{ 'border-purple-400 bg-purple-50/80': dragging }"
                                                        class="flex flex-col items-center justify-center w-full border border-dashed border-gray-200 rounded-lg py-5 px-3 cursor-pointer hover:border-purple-300 hover:bg-purple-50/50 transition"
                                                    >
                                                        <svg class="w-5 h-5 text-gray-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        <span class="text-xs text-gray-400">
                                                            <span class="text-purple-500 font-medium">Klik untuk upload</span> atau seret foto
                                                        </span>
                                                        <span class="text-[10px] text-gray-300 mt-0.5">PNG, JPG, WebP (max 2MB)</span>
                                                        <input type="file" wire:model="variants.{{ $i }}.images" accept="image/*" multiple class="hidden" x-ref="fileInput">
                                                    </label>
                                                    @error("variants.{$i}.images") <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                                    @error("variants.{$i}.images.*") <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi Varian</label>
                                                    <textarea
                                                        wire:model="variants.{{ $i }}.description"
                                                        rows="3"
                                                        placeholder="Detail tambahan varian..."
                                                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none resize-none transition-shadow"
                                                    ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="border-2 border-dashed border-gray-200 rounded-xl py-8 px-6 text-center">
                                <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500">Belum ada varian</p>
                                <p class="mt-1 text-xs text-gray-400">Klik tombol <span class="text-purple-500 font-medium">"Tambah"</span> di atas untuk menambahkan varian.</p>
                            </div>
                        @endif

                        @if(count($variants) > 0)
                            <button
                                type="button"
                                wire:click="addVariant"
                                class="w-full py-2.5 border-2 border-dashed border-purple-200 text-purple-500 text-sm font-medium rounded-xl hover:border-purple-400 hover:bg-purple-50 transition flex items-center justify-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Tambah Varian Lagi
                            </button>
                        @endif
                    </div>
                </form>

                {{-- Admin lightbox --}}
                @php
                    $lbImages = [];
                    foreach ($images as $img) $lbImages[] = $img->temporaryUrl();
                    foreach ($existingImages as $p) $lbImages[] = Storage::url($p);
                    foreach ($variants as $v) {
                        foreach ($v['images'] as $img) $lbImages[] = $img->temporaryUrl();
                        foreach ($v['existingImages'] as $p) $lbImages[] = Storage::url($p);
                    }
                @endphp
                @if(!empty($lbImages))
                    <div
                        x-data="{
                            lbOpen: false,
                            lbIndex: 0,
                            get lbImages() {
                                let el = this.$el.closest('[data-lb]');
                                try { return el ? JSON.parse(atob(el.dataset.lb)) : []; } catch(e) { return []; }
                            },
                            openLb(src) {
                                let i = this.lbImages.indexOf(src);
                                if (i >= 0) { this.lbIndex = i; this.lbOpen = true; document.body.style.overflow = 'hidden'; }
                            },
                            closeLb() { this.lbOpen = false; document.body.style.overflow = ''; },
                            lbPrev() { this.lbIndex = this.lbIndex === 0 ? this.lbImages.length - 1 : this.lbIndex - 1; },
                            lbNext() { this.lbIndex = this.lbIndex === this.lbImages.length - 1 ? 0 : this.lbIndex + 1; },
                        }"
                        data-lb="{{ base64_encode(json_encode($lbImages)) }}"
                        x-on:lightbox-open.window="openLb($event.detail)"
                    >
                        <template x-if="lbOpen">
                            <div
                                class="fixed inset-0 z-[100] bg-black/90 flex items-center justify-center"
                                @click.self="closeLb"
                                @keydown.escape.window="closeLb"
                            >
                                <button @click="closeLb" class="absolute top-4 right-4 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition z-10">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>

                                <template x-if="lbImages.length > 1">
                                    <button @click="lbPrev" class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition z-10">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                </template>

                                <img :key="lbIndex" :src="lbImages[lbIndex]" class="max-w-[90vw] max-h-[85vh] object-contain select-none rounded-lg">

                                <template x-if="lbImages.length > 1">
                                    <button @click="lbNext" class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition z-10">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </template>

                                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/70 text-sm font-medium bg-black/30 px-3 py-1.5 rounded-full" x-text="(lbIndex + 1) + ' / ' + lbImages.length"></div>
                            </div>
                        </template>
                    </div>
                @endif

                {{-- ── Modal Footer (sticky) ── --}}
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/80 rounded-b-2xl shrink-0">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-xs text-gray-400 hidden sm:block">
                            <span class="text-red-500">*</span> wajib diisi
                        </p>
                        <div class="flex items-center gap-3 ml-auto">
                            <button
                                type="button"
                                wire:click="closeModal"
                                class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition"
                            >Batal</button>
                            <button
                                type="submit"
                                form="product-form"
                                class="px-5 py-2.5 text-sm font-semibold text-white bg-rose-500 rounded-xl hover:bg-rose-600 active:bg-rose-700 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                                wire:loading.attr="disabled"
                            >
                                <svg wire:loading.remove wire:target="save" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <circle class="opacity-75" fill="currentColor" cx="4" cy="12" r="4"/>
                                </svg>
                                <span wire:loading.remove wire:target="save">{{ $editId ? 'Simpan Perubahan' : 'Simpan Produk' }}</span>
                                <span wire:loading wire:target="save">Menyimpan...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
