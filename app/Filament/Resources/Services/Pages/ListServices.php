<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\ServiceStatsWidget;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return ServiceResource::canCreate() ? [CreateAction::make()] : [];
    }

    protected function getHeaderWidgets(): array
    {
        return [ServiceStatsWidget::class];
    }
}
