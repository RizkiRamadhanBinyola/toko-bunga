<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn () => route('admin.login'));
        $middleware->redirectUsersTo(fn () => route('admin.dashboard'));

        // Cegah browser cache halaman Livewire agar back button tidak trigger GET ke /livewire/update
        $middleware->web(append: [
            \Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Tangani Livewire stale component saat browser back/forward
        $exceptions->render(function (
            \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e,
            \Illuminate\Http\Request $request
        ) {
            // Livewire update endpoint hanya menerima POST
            // Jika browser kirim GET (back button / stale cache), redirect ke halaman sebelumnya
            if (str_contains($request->path(), 'livewire') && str_contains($request->path(), 'update')) {
                return redirect()->back()->with('error', 'Sesi halaman sudah kedaluwarsa. Halaman telah dimuat ulang.');
            }
        });
    })->create();
