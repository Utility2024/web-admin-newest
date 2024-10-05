<?php

namespace App\Filament\Wh\Resources\MasterRackResource\Pages;

use App\Filament\Wh\Resources\MasterRackResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterRack extends ViewRecord
{
    protected static string $resource = MasterRackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
