<?php

namespace App\Filament\Esd\Resources\SolderingResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Esd\Resources\SolderingResource;

class ListSolderings extends ListRecords
{
    protected static string $resource = SolderingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('customAction')
                ->url('/esd/soldering-details')
                ->label('Go To All Measurement Of Soldering')
                ->color('success')
        ];
    }
}
