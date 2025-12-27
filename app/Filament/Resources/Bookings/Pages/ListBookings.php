<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\BookingStatsWidget;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return BookingResource::canCreate() ? [CreateAction::make()] : [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BookingStatsWidget::class,
        ];
    }
}
