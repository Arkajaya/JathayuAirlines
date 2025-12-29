<?php

namespace App\Filament\Resources\Cancellations\Pages;

use App\Filament\Resources\Cancellations\CancellationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class EditCancellation extends EditRecord
{
    protected static string $resource = CancellationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);

        // Mark as reviewed when an admin/staff opens the edit page to read the reason
        if (Auth::user() && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Staff'))) {
            if (is_null($this->record->reviewed_at)) {
                $this->record->reviewed_at = now();
                $this->record->save();
            }
        }
    }
}
