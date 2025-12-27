<?php

namespace App\Filament\Resources\Bookings;

use App\Filament\Resources\Bookings\Pages\CreateBooking;
use App\Filament\Resources\Bookings\Pages\EditBooking;
use App\Filament\Resources\Bookings\Pages\ListBookings;
use App\Filament\Resources\Bookings\Pages\ViewBooking;
use App\Filament\Resources\Bookings\Schemas\BookingForm;
use App\Filament\Resources\Bookings\Schemas\BookingInfolist;
use App\Filament\Resources\Bookings\Tables\BookingsTable;
use App\Models\Booking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use UnitEnum;


class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ShoppingCart;

    protected static ?string $navigationLabel = 'Bookings';

    protected static UnitEnum|string|null $navigationGroup = 'Business Management';

    protected static ?string $recordTitleAttribute = 'Booking';

    public static function form(Schema $schema): Schema
    {
        return BookingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BookingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingsTable::configure($table);
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
            'index' => ListBookings::route('/'),
            'view' => ViewBooking::route('/{record}'),
            'edit' => EditBooking::route('/{record}/edit'),
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
        return false; // bookings should be created by users via frontend, not from admin
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
        if (! $user) return false;
        if ($user->hasRole('Admin') || $user->hasRole('Staff')) return true;
        return $record ? $user->id === $record->user_id : false;
    }

    public static function canDelete($record = null): bool
    {
        $user = auth()->user();
        return $user && $user->hasRole('Admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && ($user->hasRole('Admin') || $user->hasRole('Staff'));
    }
}
