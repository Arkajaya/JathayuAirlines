<?php

namespace App\Filament\Resources\ActivityLogs\Pages;

use App\Filament\Resources\ActivityLogs\ActivityLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\ActivityLogStatsWidget;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;

    protected function getHeaderActions(): array
    {
        return ActivityLogResource::canCreate() ? [CreateAction::make()] : [];
    }

    protected function getHeaderWidgets(): array
    {
        return [ActivityLogStatsWidget::class];
    }
}
