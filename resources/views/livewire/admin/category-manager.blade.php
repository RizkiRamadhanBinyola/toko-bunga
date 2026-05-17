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

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Categories</h1>
        <button wire:click="openCreate" class="px-4 py-2 text-sm font-medium text-white bg-rose-500 rounded-lg hover:bg-rose-600 transition">
            + Add Category
        </button>
    </div>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 overflow-hidden">
        @if($parents->isEmpty())
            <div class="p-12 text-center">
                <svg class="mx-auto w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <p class="mt-4 text-sm text-gray-400">No categories yet. Click "Add Category" to create one.</p>
            </div>
        @else
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="text-right px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($parents as $parent)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($parent->thumbnail)
                                        <img src="{{ Storage::url($parent->thumbnail) }}" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-rose-50 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                        </div>
                                    @endif
                                    <span class="text-sm font-medium text-gray-900">{{ $parent->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-medium text-gray-500">Parent</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $parent->status ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $parent->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="openEdit({{ $parent->id }})" class="text-sm text-blue-600 hover:text-blue-800 mr-3">Edit</button>
                                <button wire:click="delete({{ $parent->id }})" wire:confirm="Hapus kategori ini?" class="text-sm text-red-500 hover:text-red-700">Delete</button>
                            </td>
                        </tr>
                        @foreach($children->where('parent_id', $parent->id) as $child)
                            <tr class="bg-gray-50/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3 pl-8">
                                        <span class="text-xs text-gray-400">└</span>
                                        @if($child->thumbnail)
                                            <img src="{{ Storage::url($child->thumbnail) }}" class="w-8 h-8 rounded-lg object-cover">
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-rose-50/50 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                            </div>
                                        @endif
                                        <span class="text-sm text-gray-700">{{ $child->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-medium text-gray-400">Subcategory</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $child->status ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $child->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button wire:click="openEdit({{ $child->id }})" class="text-sm text-blue-600 hover:text-blue-800 mr-3">Edit</button>
                                    <button wire:click="delete({{ $child->id }})" wire:confirm="Hapus subkategori ini?" class="text-sm text-red-500 hover:text-red-700">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $editId ? 'Edit Category' : 'Add Category' }}</h2>
                    <button wire:click="closeModal" class="p-1 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" wire:model.live="name" wire:blur="generateSlug" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" wire:model="slug" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sub Kategori Dari (opsional)</label>
                        <select wire:model="parentId" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none">
                            <option value="">— Kategori Utama —</option>
                            @foreach($categoryOptions as $opt)
                                <option value="{{ $opt->id }}" @if($editId === $opt->id) disabled @endif>{{ $opt->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                        @if($existingThumbnail)
                            <div class="mb-2 relative inline-block">
                                <img src="{{ Storage::url($existingThumbnail) }}" class="w-20 h-20 rounded-lg object-cover">
                                <button type="button" wire:click="$set('existingThumbnail', null)" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs">×</button>
                            </div>
                        @endif
                        <input type="file" wire:model="thumbnail" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
                        @error('thumbnail') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" wire:model="status" id="status" class="rounded border-gray-300 text-rose-500 focus:ring-rose-500">
                        <label for="status" class="text-sm text-gray-700">Active</label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-rose-500 rounded-lg hover:bg-rose-600 transition">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
