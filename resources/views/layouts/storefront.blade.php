@php $storeName = \App\Models\Setting::get('store_name', config('app.name')); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $storeName) — {{ $storeName }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-800">
    <livewire:storefront.navbar />

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">{{ $storeName }}</h3>
                    <p class="mt-4 text-sm text-gray-500">
                        {{ \App\Models\Setting::get('store_description', 'Menyediakan rangkaian bunga papan terbaik untuk berbagai acara Anda.') }}
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">Kategori</h3>
                    <ul class="mt-4 space-y-2">
                        @foreach(\App\Models\Category::parents()->active()->get() as $cat)
                            <li>
                                <a href="{{ route('category.show', $cat->slug) }}" wire:navigate class="text-sm text-gray-500 hover:text-rose-500">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">Kontak</h3>
                    <ul class="mt-4 space-y-2 text-sm text-gray-500">
                        <li>WhatsApp: {{ \App\Models\Setting::get('whatsapp_number', '0812-3456-7890') }}</li>
                        <li>{{ \App\Models\Setting::get('store_address', 'Jakarta, Indonesia') }}</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-400 text-center">
                    &copy; {{ date('Y') }} {{ $storeName }}. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
