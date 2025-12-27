<?php

namespace App\Filament\Resources\Cancellations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput as Input;
use Filament\Schemas\Schema;
use App\Models\Booking;
use App\Models\User;

class CancellationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('booking_id')
                    ->label('Booking')
                    ->options(Booking::pluck('booking_code', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Select::make('user_id')
                    ->label('User')
                    ->options(User::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Textarea::make('reason')->required()->columnSpanFull(),
                Select::make('status')->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'])->default('pending'),
                Textarea::make('admin_note')->nullable()->columnSpanFull(),
                Input::make('refund_amount')->numeric()->nullable(),
            ]);
    }
}
