<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\User;
use App\Models\Service;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Select::make('service_id')
                    ->label('Service')
                    ->options(Service::pluck('flight_number', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Repeater::make('passenger_details')
                    ->label('Passengers')
                    ->schema([
                        TextInput::make('name')->required(),
                        DatePicker::make('birth_date')->required(),
                        TextInput::make('passport')->required(),
                    ])
                    ->columns(1)
                    ->required(),
                TextInput::make('passenger_count')
                    ->label('Passenger Count')
                    ->numeric()
                    ->required(),
                TextInput::make('total_price')
                    ->numeric()
                    ->required()->label('Total Price')->prefix('Rp'),
                Select::make('payment_method')
                    ->options(['credit_card' => 'Credit Card', 'bank_transfer' => 'Bank Transfer', 'e-wallet' => 'E-Wallet'])
                    ->nullable(),
                Select::make('payment_status')
                    ->options(['pending' => 'Pending', 'paid' => 'Paid', 'failed' => 'Failed'])
                    ->default('pending'),
                Textarea::make('special_request')->nullable()->columnSpanFull(),
                TextInput::make('booking_code')->required()->disabled(),
            ]);
    }
}
