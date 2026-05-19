<div>
    <h1 class="text-2xl font-semibold text-gray-900">Settings</h1>

    @if(session('message'))
        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
            {{ session('message') }}
        </div>
    @endif

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
