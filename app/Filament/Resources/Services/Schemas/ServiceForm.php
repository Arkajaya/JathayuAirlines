<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('flight_number')
                    ->label('Flight Number')
                    ->placeholder('e.g. GA123')
                    ->helperText('Unique flight identifier')
                    ->required(),

                TextInput::make('airline_name')
                    ->label('Airline')
                    ->placeholder('e.g. Garuda Indonesia')
                    ->required(),

                TextInput::make('departure_city')
                    ->label('Departure City')
                    ->placeholder('e.g. Jakarta (CGK)')
                    ->required(),

                TextInput::make('arrival_city')
                    ->label('Arrival City')
                    ->placeholder('e.g. Bali (DPS)')
                    ->required(),

                DateTimePicker::make('departure_time')
                    ->label('Departure Time')
                    ->required(),

                DateTimePicker::make('arrival_time')
                    ->label('Arrival Time')
                    ->required(),
                // Duration is calculated automatically from departure and arrival times.

                Select::make('class')
                    ->label('Class')
                    ->options(['economy' => 'Economy', 'business' => 'Business', 'first' => 'First'])
                    ->required(),

                TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->prefix('Rp ')
                    ->placeholder('0')
                    ->helperText('Set base ticket price'),

                TextInput::make('capacity')
                    ->label('Capacity')
                    ->numeric()
                    ->placeholder('e.g. 180')
                    ->required(),

                TextInput::make('booked_seats')
                    ->label('Booked Seats')
                    ->numeric()
                    ->default(0)
                    ->helperText('Optional: number of seats already booked (leave blank to default to 0)'),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(4)
                    ->columnSpanFull()
                    ->placeholder('Add a short description about the service (airline, amenities, notes).'),

                Toggle::make('is_active')
                    ->label('Active')
                    ->helperText('Toggle to make the service available for booking')
                    ->inline(false),
            ]);
    }
}
