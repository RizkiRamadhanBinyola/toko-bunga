<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure writable temp directory (fix for Livewire file uploads on InfinityFree)
        $tmpDir = storage_path('tmp');
        if (! is_dir($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        putenv('TMPDIR='.$tmpDir);
        putenv('TEMP='.$tmpDir);
        putenv('TMP='.$tmpDir);
    }
}
