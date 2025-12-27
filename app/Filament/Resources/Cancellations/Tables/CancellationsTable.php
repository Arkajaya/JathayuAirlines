<?php

namespace App\Filament\Resources\Cancellations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;


class CancellationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking.booking_code')->label('Booking')->searchable()->sortable(),
                TextColumn::make('user.name')->label('User')->searchable()->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => null,
                    })
                    ->searchable(),
                IconColumn::make('refund_method')
                    ->label('Refund')
                    ->icon(fn ($state) => $state === 'bank_transfer' ? Heroicon::Banknotes : ( $state === 'wallet' ? Heroicon::CreditCard : null ))
                    ->sortable(),
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
                // EditAction::make()->visible(fn ($record) => auth()->user() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Staff'))),
                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => auth()->user() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Staff')) && $record->status === 'pending')
                    ->action(function ($record) {
                        $record->status = 'approved';
                        $record->save();

                        if ($record->booking) {
                            $record->booking->update(['status' => 'cancelled']);
                        }

                        Notification::make()
                            ->title('Cancellation approved')
                            ->success()
                            ->send();
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => auth()->user() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Staff')) && $record->status === 'pending')
                    ->action(function ($record) {
                        $record->status = 'rejected';
                        $record->save();

                        Notification::make()
                            ->title('Cancellation rejected')
                            ->danger()
                            ->send();
                    }),
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
