<?php

namespace App\Filament\Resources\Cancellations;

use App\Filament\Resources\Cancellations\Pages\CreateCancellation;
use App\Filament\Resources\Cancellations\Pages\EditCancellation;
use App\Filament\Resources\Cancellations\Pages\ListCancellations;
use App\Filament\Resources\Cancellations\Schemas\CancellationForm;
use App\Filament\Resources\Cancellations\Tables\CancellationsTable;
use App\Models\Cancellation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;


class CancellationResource extends Resource
{
    protected static ?string $model = Cancellation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Canccelation';

    public static function form(Schema $schema): Schema
    {
        return CancellationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CancellationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCancellations::route('/'),
            'create' => CreateCancellation::route('/create'),
            'edit' => EditCancellation::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function canCreate(): bool
    {
        return (bool) auth()->user(); // authenticated users can request cancellations
    }

    public static function canView($record = null): bool
    {
        $user = auth()->user();
        if (! $user) return false;
        if ($user->hasRole('Admin') || $user->hasRole('Staff')) return true;
        return $record ? $user->id === $record->user_id : true;
    }

    public static function canEdit($record = null): bool
    {
        $user = auth()->user();
        // Staff and Admin can edit cancellation details/status
        return $user && ($user->hasRole('Admin') || $user->hasRole('Staff'));
    }

    public static function canDelete($record = null): bool
    {
        $user = auth()->user();
        return $user && $user->hasRole('Admin');
    }
}
