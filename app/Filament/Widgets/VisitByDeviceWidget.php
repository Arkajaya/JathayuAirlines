<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Throwable;

class VisitByDeviceWidget extends Widget
{
    protected string $view = 'filament.widgets.visit-by-device-widget';

    public static function canView(): bool
    {
        return auth()->check();
    }

    public function getData()
    {
        return [
            'mobile' => 50,
            'website' => 40,
            'others' => 10,
        ];
    }
}
