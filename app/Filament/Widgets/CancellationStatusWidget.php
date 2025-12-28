<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class CancellationStatusWidget extends Widget
{
    protected string $view = 'filament.widgets.cancellation-status-widget';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        $total = DB::table('cancellations')->count();
        $pending = DB::table('cancellations')->where('status', 'pending')->count();
        $approved = DB::table('cancellations')->where('status', 'approved')->count();
        $rejected = DB::table('cancellations')->where('status', 'rejected')->count();

        $palette = ['#3674B5', '#578FCA', '#A1E3F9', '#D1F8EF'];

        return view($this->view, compact('total', 'pending', 'approved', 'rejected', 'palette'));
    }
}
