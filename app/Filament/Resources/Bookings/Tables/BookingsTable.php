<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User')->searchable()->sortable(),
                TextColumn::make('service.flight_number')->label('Flight')->searchable()->sortable(),
                TextColumn::make('passenger_count')->numeric()->sortable(),
                TextColumn::make('total_price')->money('idr')->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('booking_code')
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->visible(fn ($record) => auth()->user() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Staff') || auth()->id() === $record->user_id)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn () => auth()->user() && auth()->user()->hasRole('Admin')),
                    ForceDeleteBulkAction::make()->visible(fn () => auth()->user() && auth()->user()->hasRole('Admin')),
                    RestoreBulkAction::make()->visible(fn () => auth()->user() && auth()->user()->hasRole('Admin')),
                ]),
            ]);
    }
}
