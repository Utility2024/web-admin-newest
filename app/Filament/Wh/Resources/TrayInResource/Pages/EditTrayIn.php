<?php

namespace App\Filament\Wh\Resources\TrayInResource\Pages;

use App\Filament\Wh\Resources\TrayInResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrayIn extends EditRecord
{
    protected static string $resource = TrayInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
