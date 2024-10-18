<?php

namespace App\Filament\Utility\Resources\AcResource\Pages;

use App\Filament\Utility\Resources\AcResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAc extends EditRecord
{
    protected static string $resource = AcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
