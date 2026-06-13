<div>
    <h1 class="text-2xl font-semibold text-gray-900">Settings</h1>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
        <form wire:submit="save" class="space-y-4">
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
                <textarea wire:model="homeBannerDescription" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"></textarea>
                @error('homeBannerDescription') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
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

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Footer</label>
                <textarea wire:model="storeDescription" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"></textarea>
                @error('storeDescription') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-rose-500 rounded-lg hover:bg-rose-600 transition">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
