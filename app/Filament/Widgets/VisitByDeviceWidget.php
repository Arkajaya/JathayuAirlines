<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class VisitByDeviceWidget extends Widget
{
    protected string $view = 'filament.widgets.visit-by-device-widget';

    public function getData()
    {
        return [
            'mobile' => 50,
            'website' => 40,
            'others' => 10,
        ];
    }
}
