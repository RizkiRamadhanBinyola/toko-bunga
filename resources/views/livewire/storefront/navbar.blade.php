<div
    x-data="{
        mobileOpen: false,
        catOpen: false,      /* desktop dropdown */
        mobileCatOpen: false /* mobile accordion */
    }"
    class="bg-white border-b border-gray-100 sticky top-0 z-40"
    @keydown.escape.window="mobileOpen = false; catOpen = false"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- ── Logo ─────────────────────────────────────────────── --}}
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 shrink-0">
                <svg class="w-7 h-7 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                <span class="text-lg font-semibold text-gray-800 truncate max-w-[140px] sm:max-w-none">
                    {{ \App\Models\Setting::get('store_name', config('app.name')) }}
                </span>
            </a>

            {{-- ── Desktop nav ──────────────────────────────────────── --}}
            <nav class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}" wire:navigate
                   class="px-3 py-2 text-sm font-medium rounded-lg transition
                          {{ request()->routeIs('home') ? 'text-rose-500 bg-rose-50' : 'text-gray-600 hover:text-rose-500 hover:bg-rose-50' }}">
                    Home
                </a>

                <a href="{{ route('products') }}" wire:navigate
                   class="px-3 py-2 text-sm font-medium rounded-lg transition
                          {{ request()->routeIs('products') && !request('category') ? 'text-rose-500 bg-rose-50' : 'text-gray-600 hover:text-rose-500 hover:bg-rose-50' }}">
                    Semua Produk
                </a>

                {{-- Dropdown Kategori (hover) --}}
                <div class="relative" @mouseenter="catOpen = true" @mouseleave="catOpen = false">
                    <button
                        @click="catOpen = !catOpen"
                        class="flex items-center gap-1 px-3 py-2 text-sm font-medium rounded-lg transition
                               {{ request()->routeIs('products') && request('category') ? 'text-rose-500 bg-rose-50' : 'text-gray-600 hover:text-rose-500 hover:bg-rose-50' }}"
                    >
                        Kategori
                        <svg class="w-4 h-4 transition-transform duration-200" :class="catOpen ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div
                        x-show="catOpen"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="absolute top-full left-0 mt-1 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50"
                        @click="catOpen = false"
                    >
                        <a href="{{ route('products') }}" wire:navigate
                           class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-rose-500 hover:bg-rose-50">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            Semua Kategori
                        </a>
                        <div class="my-1 border-t border-gray-100"></div>

                        @foreach($categories as $cat)
                            @if($cat->children->isNotEmpty())
                                <div class="relative"
                                     @mouseenter="$el.querySelector('.submenu').classList.remove('hidden')"
                                     @mouseleave="$el.querySelector('.submenu').classList.add('hidden')">
                                    <a href="{{ route('products', ['category' => $cat->slug]) }}" wire:navigate
                                       class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-rose-50 hover:text-rose-600
                                              {{ request('category') === $cat->slug ? 'bg-rose-50 text-rose-600 font-medium' : '' }}">
                                        {{ $cat->name }}
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                    <div class="submenu hidden absolute left-full top-0 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 ml-1 z-50">
                                        <a href="{{ route('products', ['category' => $cat->slug]) }}" wire:navigate
                                           class="block px-4 py-2 text-sm text-gray-500 hover:bg-rose-50 hover:text-rose-600 italic">
                                            Semua {{ $cat->name }}
                                        </a>
                                        <div class="my-1 border-t border-gray-100"></div>
                                        @foreach($cat->children as $child)
                                            <a href="{{ route('products', ['category' => $child->slug]) }}" wire:navigate
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-rose-50 hover:text-rose-600
                                                      {{ request('category') === $child->slug ? 'bg-rose-50 text-rose-600 font-medium' : '' }}">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('products', ['category' => $cat->slug]) }}" wire:navigate
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-rose-50 hover:text-rose-600
                                          {{ request('category') === $cat->slug ? 'bg-rose-50 text-rose-600 font-medium' : '' }}">
                                    {{ $cat->name }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </nav>

            {{-- ── Right side ───────────────────────────────────────── --}}
            <div class="flex items-center gap-2">
                {{-- WA button — hidden on xs, visible sm+ --}}
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281234567890') }}"
                   target="_blank"
                   class="hidden sm:flex items-center gap-2 px-3 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    <span class="hidden md:inline">Hubungi Kami</span>
                </a>

                {{-- WA icon only on xs --}}
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281234567890') }}"
                   target="_blank"
                   class="sm:hidden p-2 text-green-500 rounded-lg hover:bg-green-50 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </a>

                {{-- Hamburger (mobile only) --}}
                <button
                    @click="mobileOpen = !mobileOpen"
                    class="lg:hidden p-2 text-gray-500 rounded-lg hover:bg-gray-100 transition"
                    :aria-expanded="mobileOpen"
                    aria-label="Menu"
                >
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ── Mobile menu ──────────────────────────────────────────────── --}}
    <div
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden border-t border-gray-100 bg-white shadow-lg max-h-[80vh] overflow-y-auto"
        style="display:none"
    >
        <div class="px-4 py-3 space-y-0.5">

            {{-- Home --}}
            <a href="{{ route('home') }}" wire:navigate
               @click="mobileOpen = false"
               class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition
                      {{ request()->routeIs('home') ? 'text-rose-500 bg-rose-50' : 'text-gray-700 hover:bg-rose-50 hover:text-rose-600' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Home
            </a>

            {{-- Semua Produk --}}
            <a href="{{ route('products') }}" wire:navigate
               @click="mobileOpen = false"
               class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition
                      {{ request()->routeIs('products') && !request('category') ? 'text-rose-500 bg-rose-50' : 'text-gray-700 hover:bg-rose-50 hover:text-rose-600' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Semua Produk
            </a>

            {{-- Kategori accordion --}}
            <div>
                <button
                    @click="mobileCatOpen = !mobileCatOpen"
                    class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg transition
                           {{ request()->routeIs('products') && request('category') ? 'text-rose-500 bg-rose-50' : 'text-gray-700 hover:bg-rose-50 hover:text-rose-600' }}"
                >
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Kategori
                    </span>
                    <svg class="w-4 h-4 transition-transform duration-200 shrink-0" :class="mobileCatOpen ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Accordion content --}}
                <div
                    x-show="mobileCatOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="mt-1 ml-3 pl-3 border-l-2 border-rose-100 space-y-0.5"
                    style="display:none"
                >
                    @foreach($categories as $cat)
                        <a href="{{ route('products', ['category' => $cat->slug]) }}" wire:navigate
                           @click="mobileOpen = false"
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition
                                  {{ request('category') === $cat->slug ? 'text-rose-500 bg-rose-50 font-medium' : 'text-gray-700 hover:bg-rose-50 hover:text-rose-600' }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-300 shrink-0"></span>
                            {{ $cat->name }}
                        </a>
                        @foreach($cat->children as $child)
                            <a href="{{ route('products', ['category' => $child->slug]) }}" wire:navigate
                               @click="mobileOpen = false"
                               class="flex items-center gap-2 pl-6 pr-3 py-1.5 text-sm rounded-lg transition
                                      {{ request('category') === $child->slug ? 'text-rose-500 bg-rose-50 font-medium' : 'text-gray-500 hover:bg-rose-50 hover:text-rose-600' }}">
                                <span class="text-gray-300 text-xs shrink-0">└</span>
                                {{ $child->name }}
                            </a>
                        @endforeach
                    @endforeach
                </div>
            </div>

            {{-- WhatsApp --}}
            <div class="pt-2 mt-1 border-t border-gray-100">
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281234567890') }}"
                   target="_blank"
                   @click="mobileOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-green-600 rounded-lg hover:bg-green-50 transition">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
