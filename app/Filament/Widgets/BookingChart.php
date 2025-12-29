<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BookingChart extends Widget
{
    protected string $view = 'filament.widgets.booking-chart';

    protected ?string $heading = 'Bookings';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['Admin','Staff']);
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        $labels = [];
        $series = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i)->format('M d');
            $labels[] = $day;
            $series[] = DB::table('bookings')->whereDate('created_at', Carbon::today()->subDays($i))->count();
        }

        return view($this->view, compact('labels', 'series'));
    }
}
