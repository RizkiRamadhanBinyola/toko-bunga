<div>
    <h1 class="text-2xl font-semibold text-gray-900">Pengaturan SEO & Favicon</h1>
    <p class="mt-1 text-sm text-gray-500">Atur meta tag, Open Graph, dan favicon untuk tampilan website toko Anda.</p>

    <div class="mt-6 space-y-6 max-w">
        {{-- SEO Meta --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form wire:submit="save" class="space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">SEO — Meta Tags</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description <span class="text-gray-400 font-normal">(default)</span></label>
                    <textarea wire:model="seoMetaDescription" rows="2" maxlength="500" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none" placeholder="Deskripsi website yang muncul di hasil pencarian Google"></textarea>
                    <p class="mt-1 text-xs text-gray-400">Maksimal 500 karakter. Akan dipakai sebagai fallback jika halaman tidak memiliki meta description sendiri.</p>
                    @error('seoMetaDescription') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Open Graph</h2>
                <p class="text-xs text-gray-400 -mt-4 mb-4">Pengaturan ini dipakai saat link website dibagikan di WhatsApp, Facebook, atau media sosial lainnya.</p>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OG Title <span class="text-gray-400 font-normal">(default)</span></label>
                    <input type="text" wire:model="seoOgTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none" placeholder="Kosongkan untuk menggunakan judul halaman">
                    @error('seoOgTitle') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OG Description <span class="text-gray-400 font-normal">(default)</span></label>
                    <textarea wire:model="seoOgDescription" rows="2" maxlength="500" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none" placeholder="Kosongkan untuk menggunakan meta description"></textarea>
                    @error('seoOgDescription') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OG Image <span class="text-gray-400 font-normal">(1200×630px direkomendasikan)</span></label>
                    <input type="file" wire:model="seoOgImageUpload" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100">
                    @error('seoOgImageUpload') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    @if($seoOgImage)
                        <div class="mt-2 flex items-center gap-3">
                            <img src="{{ Storage::url($seoOgImage) }}" class="h-16 object-contain rounded-lg border border-gray-200">
                            <button type="button" wire:click="removeOgImage" class="text-xs text-red-500 hover:text-red-700">Hapus</button>
                        </div>
                    @endif
                </div>

                <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Favicon</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Favicon <span class="text-gray-400 font-normal">(PNG, ICO, atau SVG, maks 1MB)</span></label>
                    <input type="file" wire:model="faviconUpload" accept=".png,.ico,.svg" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100">
                    @error('faviconUpload') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    @if($favicon)
                        <div class="mt-2 flex items-center gap-3">
                            <img src="{{ Storage::url($favicon) }}" class="w-8 h-8 object-contain rounded border border-gray-200">
                            <span class="text-xs text-gray-400">Favicon saat ini</span>
                            <button type="button" wire:click="removeFavicon" class="text-xs text-red-500 hover:text-red-700">Hapus</button>
                        </div>
                    @else
                        <p class="mt-2 text-xs text-gray-400">Saat ini menggunakan favicon default 💐</p>
                    @endif
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-rose-500 rounded-lg hover:bg-rose-600 transition">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
