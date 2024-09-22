<?php

namespace App\Filament\Esd\Resources\GroundMonitorBoxDetailResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Esd\Resources\GroundMonitorBoxDetailResource;
use App\Filament\Esd\Resources\GroundMonitorBoxDetailResource\Widgets\StandartGb;

class ListGroundMonitorBoxDetails extends ListRecords
{
    protected static string $resource = GroundMonitorBoxDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            StandartGb::class,
        ];
    }
}
