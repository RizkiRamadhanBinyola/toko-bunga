<div>
    {{-- ── Toast Notification ─────────────────────────────────────── --}}
    <div
        x-data="{ show: false, message: '', type: 'success' }"
        x-on:show-toast.window="
            message = $event.detail.message;
            type    = $event.detail.type ?? 'success';
            show    = true;
            setTimeout(() => show = false, 3500);
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed bottom-6 right-6 z-[100] flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-xl text-sm font-medium text-white min-w-[220px]"
        :class="type === 'success' ? 'bg-emerald-500' : 'bg-red-500'"
        style="display:none"
    >
        <template x-if="type === 'success'">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </template>
        <template x-if="type === 'error'">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </template>
        <span x-text="message"></span>
    </div>

    {{-- ── Header ──────────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-semibold text-gray-900">Produk</h1>
        <div class="flex items-center gap-3">
            <input
                type="text"
                wire:model.live.debounce="search"
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
                                        wire:click="delete({{ $product->id }})"
                                        wire:confirm="Hapus produk '{{ $product->name }}'?"
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
        <div class="fixed inset-0 z-50 flex items-start justify-center bg-black/40 overflow-y-auto py-8">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 p-6">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">
                        {{ $editId ? 'Edit Produk' : 'Tambah Produk' }}
                    </h2>
                    <button wire:click="closeModal" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-5">

                    {{-- ── Nama + Slug Preview ── --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="name"
                            placeholder="Bouquet Mawar Merah"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"
                        >
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        {{-- Slug preview realtime via Alpine --}}
                        <p
                            x-data="{
                                get slug() {
                                    return ($wire.name || '')
                                        .toLowerCase()
                                        .normalize('NFD')
                                        .replace(/[\u0300-\u036f]/g, '')
                                        .replace(/[^a-z0-9\s-]/g, '')
                                        .trim()
                                        .replace(/[\s_]+/g, '-')
                                        .replace(/-+/g, '-');
                                }
                            }"
                            class="mt-1.5 text-xs text-gray-400 flex items-center gap-1"
                        >
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <span>URL: /product/</span><span x-text="slug || '...'" class="font-mono text-gray-500"></span>
                        </p>
                    </div>

                    {{-- ── Kategori & Status ── --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                            <select wire:model="categoryId" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
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
                            @error('categoryId') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex flex-col justify-end">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="status" class="rounded border-gray-300 text-rose-500 focus:ring-rose-500">
                                <span class="text-sm font-medium text-gray-700">Produk Aktif</span>
                            </label>
                        </div>
                    </div>

                    {{-- ── Thumbnail ── --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Utama</label>
                        @if($existingThumbnail)
                            <div class="mb-2 flex items-center gap-3">
                                <img src="{{ Storage::url($existingThumbnail) }}" class="w-16 h-16 rounded-lg object-cover border border-gray-200">
                                <button type="button" wire:click="$set('existingThumbnail', null)" class="text-xs text-red-500 hover:text-red-700">Hapus foto</button>
                            </div>
                        @endif
                        <input
                            type="file"
                            wire:model="thumbnail"
                            accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100"
                        >
                        @error('thumbnail') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- ── Deskripsi & Harga Dasar ── --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea
                                wire:model="description"
                                rows="3"
                                placeholder="Deskripsi produk..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none resize-none"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Dasar (Rp) <span class="text-red-500">*</span></label>
                            <input
                                type="number"
                                wire:model="price"
                                placeholder="150000"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"
                            >
                            @error('price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            <p class="mt-1 text-xs text-gray-400">Digunakan jika tidak ada varian.</p>
                        </div>
                    </div>

                    {{-- ── Variants ── --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-800">Varian <span class="text-gray-400 font-normal">(opsional)</span></h3>
                                <p class="text-xs text-gray-400 mt-0.5">Tambahkan varian jika produk memiliki pilihan ukuran/jenis berbeda.</p>
                            </div>
                        </div>

                        @if(count($variants) > 0)
                            <div class="space-y-4">
                                @foreach($variants as $i => $variant)
                                    <div class="border border-gray-200 rounded-xl p-4 bg-gray-50/50 relative">
                                        {{-- Variant header --}}
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Varian {{ $i + 1 }}</span>
                                            <button
                                                type="button"
                                                wire:click="removeVariant({{ $i }})"
                                                class="p-1 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition"
                                                title="Hapus varian"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                            {{-- Foto varian --}}
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Foto</label>
                                                @if(!empty($variant['existingImage']))
                                                    <div class="mb-2 flex items-center gap-2">
                                                        <img src="{{ Storage::url($variant['existingImage']) }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                                        <button
                                                            type="button"
                                                            wire:click="$set('variants.{{ $i }}.existingImage', null)"
                                                            class="text-xs text-red-500 hover:text-red-700"
                                                        >Hapus</button>
                                                    </div>
                                                @endif
                                                <input
                                                    type="file"
                                                    wire:model="variants.{{ $i }}.image"
                                                    accept="image/*"
                                                    class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-white file:text-gray-700 hover:file:bg-gray-100 file:border file:border-gray-200"
                                                >
                                                @error("variants.{$i}.image") <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                            </div>

                                            {{-- Deskripsi varian --}}
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi</label>
                                                <textarea
                                                    wire:model="variants.{{ $i }}.description"
                                                    rows="3"
                                                    placeholder="Ukuran, detail, dll..."
                                                    class="w-full px-2.5 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none resize-none"
                                                ></textarea>
                                            </div>

                                            {{-- Harga varian --}}
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Harga (Rp)</label>
                                                <input
                                                    type="number"
                                                    wire:model="variants.{{ $i }}.price"
                                                    placeholder="Kosong = pakai harga dasar"
                                                    min="0"
                                                    class="w-full px-2.5 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"
                                                >
                                                @error("variants.{$i}.price") <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center">
                                <svg class="mx-auto w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <p class="mt-2 text-xs text-gray-400">Belum ada varian. Klik tombol di bawah untuk menambahkan.</p>
                            </div>
                        @endif

                        <button
                            type="button"
                            wire:click="addVariant"
                            class="mt-3 w-full py-2.5 border-2 border-dashed border-rose-200 text-rose-500 text-sm font-medium rounded-xl hover:border-rose-400 hover:bg-rose-50 transition flex items-center justify-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Tambah Varian
                        </button>
                    </div>

                    {{-- ── Actions ── --}}
                    <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                        <button
                            type="button"
                            wire:click="closeModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition"
                        >Batal</button>
                        <button
                            type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-rose-500 rounded-lg hover:bg-rose-600 transition"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-75"
                        >
                            <span wire:loading.remove wire:target="save">Simpan Produk</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
