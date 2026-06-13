@php
    $storeName = \App\Models\Setting::get('store_name', config('app.name'));
    $favicon = \App\Models\Setting::get('favicon', '');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Ditolak — {{ $storeName }}</title>
    @if($favicon)
        <link rel="icon" href="{{ Storage::url($favicon) }}" type="image/png">
    @else
        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💐</text></svg>" type="image/svg+xml">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-800 min-h-screen flex items-center justify-center">
    <div class="text-center px-4">
        <div class="text-8xl font-bold text-rose-200 mb-4">403</div>
        <h1 class="text-2xl font-semibold text-gray-900 mb-2">Akses Ditolak</h1>
        <p class="text-gray-500 mb-8">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-3 bg-rose-500 text-white rounded-full hover:bg-rose-600 transition font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
