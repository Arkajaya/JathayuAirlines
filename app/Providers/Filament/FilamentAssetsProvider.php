<?php

namespace App\Providers\Filament;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class FilamentAssetsProvider extends ServiceProvider
{
    public function register(): void
    {
        // no-op
    }

    public function boot(): void
    {
        // Previously attempted to register assets via Filament facade.
        // Modern Filament manager may not expose registerStylesheet/registerScript
        // so we inject assets via middleware `InjectFilamentAssets` instead.
    }
}
