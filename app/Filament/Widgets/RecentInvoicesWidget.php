<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class RecentInvoicesWidget extends Widget
{
    protected string $view = 'filament.widgets.recent-invoices-widget';

    public function getInvoices()
    {
        $start = request()->query('dashboard_start');
        $end = request()->query('dashboard_end');

        $q = DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->select('bookings.*', 'users.name as user_name')
            ->orderByDesc('bookings.created_at')
            ->limit(5);

        if ($start && $end) {
            try {
                $startDt = \Illuminate\Support\Carbon::parse($start)->startOfDay();
                $endDt = \Illuminate\Support\Carbon::parse($end)->endOfDay();
                $q->whereBetween('bookings.created_at', [$startDt, $endDt]);
            } catch (Throwable $e) {
                // ignore
            }
        }

        return $q->get();
    }
}
