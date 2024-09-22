<?php

namespace App\Filament\Esd\Resources\EquipmentGroundResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Esd\Resources\EquipmentGroundResource;

class ListEquipmentGrounds extends ListRecords
{
    protected static string $resource = EquipmentGroundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('customAction')
                ->url('http://portal.siix-ems.co.id/esd/equipment-ground-details')
                ->label('Go To All Measurement Of Equipment Ground')
                ->color('success')
        ];
    }
}
