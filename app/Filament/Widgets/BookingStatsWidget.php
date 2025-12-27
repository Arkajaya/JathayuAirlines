<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Throwable;

class BookingStatsWidget extends Widget
{
    protected string $view = 'filament.widgets.booking-stats-widget';

    public static function canView(): bool
    {
        // All staff and admin can see booking stats
        return auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Staff'));
    }

    public function getData(): array
    {
        $today = Carbon::today();

        $total = DB::table('bookings')->count();
        $pendingPayment = DB::table('bookings')->where('payment_status', 'pending')->count();
        $checkedIn = DB::table('bookings')->where('status', 'checked_in')->count();
        $todayCount = DB::table('bookings')->whereDate('created_at', $today)->count();

        return [
            'total' => $total,
            'pending' => $pendingPayment,
            'checked_in' => $checkedIn,
            'today' => $todayCount,
        ];
    }
}
