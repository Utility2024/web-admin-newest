<?php

namespace App\Filament\Esd\Resources\GarmentResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Esd\Resources\GarmentResource;

class ListGarments extends ListRecords
{
    protected static string $resource = GarmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('customAction')
                ->url('/esd/garment-details')
                ->label('Go To All Measurement Of Garment')
                ->color('success')
        ];
    }
}
