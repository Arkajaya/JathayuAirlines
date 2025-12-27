<?php

namespace App\Filament\Resources\Cancellations\Pages;

use App\Filament\Resources\Cancellations\CancellationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCancellations extends ListRecords
{
    protected static string $resource = CancellationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
