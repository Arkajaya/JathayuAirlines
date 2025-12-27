<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Throwable;

class CustomerGrowthWidget extends Widget
{
    protected string $view = 'filament.widgets.customer-growth-widget';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    public function getCountries()
    {
        // simple sample data; replace with queries if needed
        return [
            ['country' => 'North Korea', 'percent' => 56],
            ['country' => 'France', 'percent' => 30],
            ['country' => 'Argentina', 'percent' => 67],
        ];
    }
}
