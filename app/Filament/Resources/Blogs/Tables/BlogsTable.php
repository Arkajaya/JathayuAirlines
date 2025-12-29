<?php

namespace App\Filament\Resources\Blogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class BlogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->label('Published At')
                    ->searchable(),
                TextColumn::make('views')
                    ->label('Views')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->trueIcon(Heroicon::Check)
                    ->falseIcon(Heroicon::XMark)
                    ->trueColor('success')
                    ->falseColor('danger'),
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
                EditAction::make()->visible(fn () => auth()->user() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Staff'))),
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
