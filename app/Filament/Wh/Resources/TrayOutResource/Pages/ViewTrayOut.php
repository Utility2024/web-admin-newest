<?php

namespace App\Filament\Wh\Resources\TrayOutResource\Pages;

use App\Filament\Wh\Resources\TrayOutResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTrayOut extends ViewRecord
{
    protected static string $resource = TrayOutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
