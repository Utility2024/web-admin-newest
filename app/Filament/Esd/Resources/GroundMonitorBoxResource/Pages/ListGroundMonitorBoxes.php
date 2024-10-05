<?php

namespace App\Filament\Esd\Resources\GroundMonitorBoxResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Esd\Resources\GroundMonitorBoxResource;

class ListGroundMonitorBoxes extends ListRecords
{
    protected static string $resource = GroundMonitorBoxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('customAction')
                ->url('/esd/ground-monitor-box-details')
                ->label('Go To All Measurement Of Ground Monitor Box')
                ->color('success')
        ];
    }
}
