<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Throwable;

class PaymentOverviewWidget extends Widget
{
    protected string $view = 'filament.widgets.payment-overview-widget';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    public function getData(): array
    {
        $today = Carbon::today();

        $totalRevenue = DB::table('bookings')->where('payment_status', 'paid')->sum('total_price');
        $todayRevenue = DB::table('bookings')->where('payment_status', 'paid')->whereDate('created_at', $today)->sum('total_price');
        $pending = DB::table('bookings')->where('payment_status', 'pending')->count();
        $paidCount = DB::table('bookings')->where('payment_status', 'paid')->count();

        return [
            'totalRevenue' => number_format($totalRevenue, 0, ',', '.'),
            'todayRevenue' => number_format($todayRevenue, 0, ',', '.'),
            'pending' => $pending,
            'paidCount' => $paidCount,
        ];
    }
}
