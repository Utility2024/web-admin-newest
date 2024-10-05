<?php

namespace App\Filament\Wh\Resources\TrayInResource\Pages;

use App\Filament\Wh\Resources\TrayInResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrayIns extends ListRecords
{
    protected static string $resource = TrayInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Tray In";
    }
}
