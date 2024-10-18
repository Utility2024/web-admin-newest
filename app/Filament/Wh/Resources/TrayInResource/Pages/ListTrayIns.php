<?php

namespace App\Filament\Wh\Resources\TrayInResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Wh\Resources\TrayInResource;
use App\Filament\Wh\Resources\TrayInResource\Widgets\WarningWh;

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

    protected function getHeaderWidgets(): array
    {
        return [
            // WorksurfaceDetailStatsOverview::class,
            WarningWh::class,
        ];
    }
}
