<div>
    <h1 class="text-2xl font-semibold text-gray-900">Pengaturan Toko</h1>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6 max-w">
        <form wire:submit="save" class="space-y-8">

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- INFORMASI TOKO --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            <div>
                <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Informasi Toko</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Toko</label>
                        <input type="text" wire:model="storeName" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                        @error('storeName') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp (untuk order)</label>
                        <input type="text" wire:model="whatsappNumber" placeholder="6281234567890" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                        <p class="mt-1 text-xs text-gray-400">Gunakan kode negara tanpa tanda +, contoh: 6281234567890</p>
                        @error('whatsappNumber') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Toko</label>
                        <textarea wire:model="storeAddress" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"></textarea>
                        @error('storeAddress') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- HOME BANNER --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            <div>
                <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Home Banner</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Background Hero</label>
                        <input type="file" wire:model="homeHeroBackgroundUpload" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100">
                        @error('homeHeroBackgroundUpload') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        @if($homeHeroBackground)
                            <div class="mt-2 flex items-center gap-3">
                                <img src="{{ Storage::url($homeHeroBackground) }}" class="w-20 h-14 object-cover rounded-lg border border-gray-200">
                                <span class="text-xs text-gray-400">Background saat ini</span>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Text Banner Home - Baris 1</label>
                        <input type="text" wire:model="homeBannerHeading" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                        @error('homeBannerHeading') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Text Banner Home - Baris Highlight</label>
                        <input type="text" wire:model="homeBannerHighlight" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                        @error('homeBannerHighlight') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Text Banner Home - Baris 2</label>
                        <input type="text" wire:model="homeBannerSubheading" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                        @error('homeBannerSubheading') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Banner Home</label>
                        <textarea wire:model="homeBannerDescription" rows="2" class="w-full px-3 py-4 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"></textarea>
                        @error('homeBannerDescription') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- HOME SECTION VISIBILITY --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            <div>
                <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Home — Sections</h2>

                <div class="space-y-6">
                    {{-- Categories Section --}}
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <label class="flex items-center gap-2 mb-3">
                            <input type="checkbox" wire:model="showCategoriesSection" class="rounded border-gray-300 text-rose-500 focus:ring-rose-500">
                            <span class="text-sm font-medium text-gray-700">Tampilkan Section Kategori</span>
                        </label>
                        <div class="space-y-3 ml-6">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Judul Section</label>
                                <input type="text" wire:model="categoriesSectionTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Deskripsi Section</label>
                                <input type="text" wire:model="categoriesSectionDescription" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- Latest Products Section --}}
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <label class="flex items-center gap-2 mb-3">
                            <input type="checkbox" wire:model="showLatestProductsSection" class="rounded border-gray-300 text-rose-500 focus:ring-rose-500">
                            <span class="text-sm font-medium text-gray-700">Tampilkan Section Produk Terbaru</span>
                        </label>
                        <div class="space-y-3 ml-6">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Judul Section</label>
                                <input type="text" wire:model="latestProductsSectionTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Deskripsi Section</label>
                                <input type="text" wire:model="latestProductsSectionDescription" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- CTA Section --}}
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <label class="flex items-center gap-2 mb-3">
                            <input type="checkbox" wire:model="showCtaSection" class="rounded border-gray-300 text-rose-500 focus:ring-rose-500">
                            <span class="text-sm font-medium text-gray-700">Tampilkan Section CTA (Pesan Sekarang)</span>
                        </label>
                        <div class="space-y-3 ml-6">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Judul Section</label>
                                <input type="text" wire:model="ctaSectionTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Deskripsi Section</label>
                                <input type="text" wire:model="ctaSectionDescription" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- FOOTER --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            <div>
                <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Footer</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Footer</label>
                        <textarea wire:model="storeDescription" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"></textarea>
                        @error('storeDescription') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ mapLocation: {{ json_encode($footerMapLocation) }} }">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Google Maps</label>
                        <input type="text" wire:model="footerMapLocation" x-on:input="mapLocation = $event.target.value" placeholder="Ketik nama tempat, alamat, atau lokasi toko" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                        <p class="mt-1 text-xs text-gray-400">Preview peta akan muncul secara langsung saat Anda mengetik.</p>
                        @error('footerMapLocation') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror

                        <template x-if="mapLocation && mapLocation.trim() !== ''">
                            <div class="mt-4 border border-gray-200 rounded-2xl overflow-hidden">
                                <div class="bg-gray-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Preview Maps</div>
                                <div class="aspect-[16/9]">
                                    <iframe :src="`https://maps.google.com/maps?q=${encodeURIComponent(mapLocation)}&output=embed`" class="w-full h-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-rose-500 rounded-lg hover:bg-rose-600 transition">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
