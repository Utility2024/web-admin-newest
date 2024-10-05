<?php

namespace App\Filament\Wh\Resources\TrayOutResource\Pages;

use App\Filament\Wh\Resources\TrayOutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrayOuts extends ListRecords
{
    protected static string $resource = TrayOutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Tray Out";
    }
}
