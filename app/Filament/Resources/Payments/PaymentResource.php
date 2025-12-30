<?php

namespace App\Filament\Resources\Payments;

use App\Filament\Resources\Payments\Pages\ListPayments;
use App\Filament\Resources\Payments\Pages\ViewPayment;
use App\Filament\Resources\Bookings\BookingResource as BookingResourceAlias;
use App\Filament\Resources\Payments\Tables\PaymentsTable;
use App\Models\Booking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PaymentResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CreditCard;

    protected static ?string $navigationLabel = 'Payments';

    protected static ?string $label = 'Payment';
    protected static ?string $pluralLabel = 'Payments';

    protected static UnitEnum|string|null $navigationGroup = 'Business Management';

    protected static ?string $recordTitleAttribute = 'booking_code';

    public static function table(Table $table): Table
    {
        return PaymentsTable::configure($table);
    }

    public static function form(Schema $schema): Schema
    {
        return BookingResourceAlias::form($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BookingResourceAlias::infolist($schema);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereNotNull('payment_status');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPayments::route('/'),
            'view' => ViewPayment::route('/{record}'),
        ];
    }

    public static function canView($record = null): bool
    {
        $user = auth()->user();
        return $user && $user->hasRole('Admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && $user->hasRole('Admin');
    }
}
