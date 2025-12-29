<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_code')->label('Order')->searchable(),
                TextColumn::make('user.name')->label('Customer')->searchable()->sortable(),
                TextColumn::make('total_price')->money('idr')->sortable(),
                IconColumn::make('payment_status')
                    ->label('Paid')
                    ->boolean()
                    ->trueIcon(Heroicon::Check)
                    ->falseIcon(Heroicon::XMark)
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('payment_method')->label('Method')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([]);
    }
}
