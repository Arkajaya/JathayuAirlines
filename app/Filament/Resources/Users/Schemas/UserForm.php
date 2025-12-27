<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required()->autofocus(),
                TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => $state ? bcrypt($state) : null)
                    ->required(fn ($context) => $context === 'create'),
                Select::make('role_id')
                    ->label('Primary Role')
                    ->options(Role::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
                TextInput::make('phone')->tel()->nullable(),
                TextInput::make('address')->nullable(),
                DatePicker::make('birth_date')->nullable(),
            ]);
    }
}
