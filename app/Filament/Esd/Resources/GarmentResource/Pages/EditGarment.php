<?php

namespace App\Filament\Esd\Resources\GarmentResource\Pages;

use App\Filament\Esd\Resources\GarmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGarment extends EditRecord
{
    protected static string $resource = GarmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
