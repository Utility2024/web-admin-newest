<?php

namespace App\Filament\Wh\Resources\MasterRackResource\Pages;

use App\Filament\Wh\Resources\MasterRackResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasterRack extends EditRecord
{
    protected static string $resource = MasterRackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
