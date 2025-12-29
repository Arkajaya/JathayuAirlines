<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AdminStatsWidget extends Widget
{
    protected string $view = 'filament.widgets.admin-stats';

    protected ?string $heading = 'Overview';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        $labels = [];
        $bookingsSeries = [];
        $revenueSeries = [];
        $cancellationsSeries = [];

        for ($i = 13; $i >= 0; $i--) {
            $dt = Carbon::today()->subDays($i);
            $labels[] = $dt->format('M d');
            $bookingsSeries[] = DB::table('bookings')->whereDate('created_at', $dt)->count();
            $revenueSeries[] = (float) DB::table('bookings')->whereDate('created_at', $dt)->sum('total_price');
            $cancellationsSeries[] = DB::table('cancellations')->whereDate('created_at', $dt)->count();
        }

        $payments = DB::table('bookings')
            ->selectRaw("payment_status, COUNT(*) as cnt")
            ->groupBy('payment_status')
            ->pluck('cnt', 'payment_status')
            ->toArray();

        $paymentsData = [
            'paid' => $payments['paid'] ?? 0,
            'pending' => $payments['pending'] ?? 0,
            'refunded' => $payments['refunded'] ?? 0,
            'failed' => $payments['failed'] ?? 0,
        ];

        $totals = [
            'bookings' => array_sum($bookingsSeries),
            'revenue' => array_sum($revenueSeries),
            'cancellations' => array_sum($cancellationsSeries),
        ];

        return view($this->view, compact(
            'labels',
            'bookingsSeries',
            'revenueSeries',
            'cancellationsSeries',
            'paymentsData',
            'totals'
        ));
    }
}
