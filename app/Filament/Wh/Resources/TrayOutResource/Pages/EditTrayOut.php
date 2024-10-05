<?php

namespace App\Filament\Wh\Resources\TrayOutResource\Pages;

use App\Filament\Wh\Resources\TrayOutResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrayOut extends EditRecord
{
    protected static string $resource = TrayOutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
