<div>
    <h1 class="text-2xl font-semibold text-gray-900">Pengaturan Metode Pembayaran</h1>
    <p class="mt-1 text-sm text-gray-500">Kelola metode pembayaran yang akan ditampilkan di halaman detail produk.</p>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6 max-w">
        <form wire:submit="save" class="space-y-6">

            <div class="space-y-3" wire:key="payment-methods-wrapper">
                @forelse($paymentMethods as $index => $method)
                    <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100" wire:key="payment-method-{{ $index }}">
                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Nama Bank / Metode</label>
                                <input type="text" wire:model="paymentMethods.{{ $index }}.name" placeholder="BCA, Mandiri, GoPay, dll" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Logo</label>
                                <input type="file" wire:model="paymentMethods.{{ $index }}.logo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100">
                                @php $logoVal = $method['logo'] ?? ''; @endphp
                                @if($logoVal && is_string($logoVal))
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($logoVal) }}" class="h-10 object-contain rounded border border-gray-200 bg-white p-1">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <button
                            type="button"
                            wire:click="removePaymentMethod({{ $index }})"
                            class="shrink-0 p-2 mt-5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition"
                            title="Hapus metode"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400 text-sm">
                        Belum ada metode pembayaran. Klik tombol di bawah untuk menambah.
                    </div>
                @endforelse
            </div>

            <button
                type="button"
                wire:click="addPaymentMethod"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-rose-600 bg-rose-50 rounded-lg hover:bg-rose-100 transition"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Metode Pembayaran
            </button>

            <div class="pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-rose-500 rounded-lg hover:bg-rose-600 transition">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
