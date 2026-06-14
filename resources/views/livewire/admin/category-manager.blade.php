<div>
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Kategori</h1>
        <button wire:click="openCreate" class="px-4 py-2 text-sm font-medium text-white bg-rose-500 rounded-lg hover:bg-rose-600 transition">
            + Tambah Kategori
        </button>
    </div>

    {{-- Table --}}
    <div class="mt-6 bg-white rounded-xl border border-gray-200 overflow-hidden">
        @if($parents->isEmpty())
            <div class="p-12 text-center">
                <svg class="mx-auto w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <p class="mt-4 text-sm text-gray-400">Belum ada kategori. Klik "Tambah Kategori" untuk membuat.</p>
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
                <table class="w-full min-w-[480px]">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Nama</th>
                            <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Tipe</th>
                            <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                            <th class="text-right px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($parents as $parent)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 whitespace-nowrap">{{ $parent->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs font-medium text-gray-500">Utama</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $parent->status ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $parent->status ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap space-x-2">
                                    <button wire:click="openEdit({{ $parent->id }})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                                    <button
                                        x-on:click.prevent="
                                            Swal.fire({
                                                title: 'Hapus kategori?',
                                                text: '{{ $parent->name }} akan dihapus permanen.',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#e53e3e',
                                                cancelButtonColor: '#6b7280',
                                                confirmButtonText: 'Ya, hapus!',
                                                cancelButtonText: 'Batal',
                                            }).then((r) => r.isConfirmed && $wire.delete({{ $parent->id }}));
                                        "
                                        class="text-sm text-red-500 hover:text-red-700 font-medium"
                                    >Hapus</button>
                                </td>
                            </tr>

                            @foreach($children->where('parent_id', $parent->id) as $child)
                                <tr class="bg-gray-50/30 hover:bg-gray-50 transition">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-2 pl-8">
                                            <span class="text-xs text-gray-300 shrink-0">└</span>
                                            <span class="text-sm text-gray-700 whitespace-nowrap">{{ $child->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <span class="text-xs font-medium text-gray-400">Sub</span>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $child->status ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $child->status ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right whitespace-nowrap space-x-2">
                                        <button wire:click="openEdit({{ $child->id }})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                                        <button
                                            x-on:click.prevent="
                                                Swal.fire({
                                                    title: 'Hapus subkategori?',
                                                    text: '{{ $child->name }} akan dihapus permanen.',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#e53e3e',
                                                    cancelButtonColor: '#6b7280',
                                                    confirmButtonText: 'Ya, hapus!',
                                                    cancelButtonText: 'Batal',
                                                }).then((r) => r.isConfirmed && $wire.delete({{ $child->id }}));
                                            "
                                            class="text-sm text-red-500 hover:text-red-700 font-medium"
                                        >Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Modal --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $editId ? 'Edit Kategori' : 'Tambah Kategori' }}</h2>
                    <button wire:click="closeModal" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="name"
                            placeholder="Contoh: Fresh Flowers"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"
                        >
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        {{-- Slug preview realtime --}}
                        <p
                            x-data="{
                                name: @entangle('name'),
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
                            class="mt-1.5 text-xs text-gray-400 flex items-center gap-1"
                        >
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <span>URL: /products?category=</span><span x-text="slug || '...'" class="font-mono text-gray-500"></span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Sub Kategori Dari <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <select
                            wire:model="parentId"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none"
                        >
                            <option value="">— Kategori Utama —</option>
                            @foreach($categoryOptions as $opt)
                                <option value="{{ $opt->id }}" @if($editId === $opt->id) disabled @endif>
                                    {{ $opt->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            wire:model="status"
                            id="cat-status"
                            class="rounded border-gray-300 text-rose-500 focus:ring-rose-500"
                        >
                        <label for="cat-status" class="text-sm text-gray-700">Aktif</label>
                    </div>

                    <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                        <button
                            type="button"
                            wire:click="closeModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition"
                        >Batal</button>
                        <button
                            type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-rose-500 rounded-lg hover:bg-rose-600 transition"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-75"
                        >
                            <span wire:loading.remove wire:target="save">Simpan</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
