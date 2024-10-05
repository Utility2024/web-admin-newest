<?php

namespace App\Filament\Esd\Resources\FlooringResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Esd\Resources\FlooringResource;

class ListFloorings extends ListRecords
{
    protected static string $resource = FlooringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('customAction')
                ->url('/esd/flooring-details')
                ->label('Go To All Measurement Of Flooring')
                ->color('success')
        ];
    }
}
