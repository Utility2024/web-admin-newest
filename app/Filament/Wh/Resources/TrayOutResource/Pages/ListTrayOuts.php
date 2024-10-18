<?php

namespace App\Filament\Wh\Resources\TrayOutResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Wh\Resources\TrayOutResource;
use App\Filament\Wh\Resources\TrayOutResource\Widgets\WarningWh;

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

    protected function getHeaderWidgets(): array
    {
        return [
            // WorksurfaceDetailStatsOverview::class,
            WarningWh::class,
        ];
    }
}
