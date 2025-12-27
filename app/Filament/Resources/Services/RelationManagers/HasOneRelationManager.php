<?php

namespace App\Filament\Resources\Services\RelationManagers;

use App\Filament\Resources\Services\ServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class HasOneRelationManager extends RelationManager
{
    protected static string $relationship = 'hasOne';

    protected static ?string $relatedResource = ServiceResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
