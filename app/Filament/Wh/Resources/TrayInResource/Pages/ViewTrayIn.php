<?php

namespace App\Filament\Wh\Resources\TrayInResource\Pages;

use App\Filament\Wh\Resources\TrayInResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTrayIn extends ViewRecord
{
    protected static string $resource = TrayInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
