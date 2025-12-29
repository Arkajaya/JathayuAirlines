<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ActivityChart extends Widget
{
    protected string $view = 'filament.widgets.activity-chart';

    protected ?string $heading = 'Activity';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        $labels = [];
        $series = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i)->format('M d');
            $labels[] = $day;
            $series[] = DB::table('activity_logs')->whereDate('created_at', Carbon::today()->subDays($i))->count();
        }

        return view($this->view, compact('labels', 'series'));
    }
}
