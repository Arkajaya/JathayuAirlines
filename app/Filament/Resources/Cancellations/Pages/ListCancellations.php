<?php

namespace App\Filament\Resources\Cancellations\Pages;

use App\Filament\Resources\Cancellations\CancellationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\CancellationStatsWidget;

class ListCancellations extends ListRecords
{
    protected static string $resource = CancellationResource::class;

    protected function getHeaderActions(): array
    {
        return CancellationResource::canCreate() ? [CreateAction::make()] : [];
    }

    protected function getHeaderWidgets(): array
    {
        return [CancellationStatsWidget::class];
    }
}
