<?php

namespace App\Filament\Production\Resources\DetailWipResource\Pages;

use App\Filament\Production\Resources\DetailWipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDetailWip extends EditRecord
{
    protected static string $resource = DetailWipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
