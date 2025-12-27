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
                    ->required(),
                TextInput::make('airline_name')
                    ->required(),
                TextInput::make('departure_city')
                    ->required(),
                TextInput::make('arrival_city')
                    ->required(),
                DateTimePicker::make('departure_time')
                    ->required(),
                DateTimePicker::make('arrival_time')
                    ->required(),
                TextInput::make('duration')
                    ->required()
                    ->numeric(),
                TextInput::make('capacity')
                    ->required()
                    ->numeric(),
                TextInput::make('booked_seats')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Select::make('class')
                    ->options(['economy' => 'Economy', 'business' => 'Business', 'first' => 'First'])
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
