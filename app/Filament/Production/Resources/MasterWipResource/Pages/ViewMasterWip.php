<?php

namespace App\Filament\Production\Resources\MasterWipResource\Pages;

use App\Filament\Production\Resources\MasterWipResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterWip extends ViewRecord
{
    protected static string $resource = MasterWipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
