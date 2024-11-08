<?php

namespace App\Filament\Production\Resources\MasterWipResource\Pages;

use App\Filament\Production\Resources\MasterWipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasterWip extends EditRecord
{
    protected static string $resource = MasterWipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
