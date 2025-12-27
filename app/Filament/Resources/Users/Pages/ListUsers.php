<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\UserStatsWidget;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return UserResource::canCreate() ? [CreateAction::make()] : [];
    }

    protected function getHeaderWidgets(): array
    {
        return [UserStatsWidget::class];
    }
}
