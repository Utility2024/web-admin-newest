<?php

namespace App\Filament\Production\Resources\DetailWipResource\Pages;

use App\Filament\Production\Resources\DetailWipResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDetailWip extends ViewRecord
{
    protected static string $resource = DetailWipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
