<?php

namespace App\Filament\Esd\Resources\IonizerResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Esd\Resources\IonizerResource;

class ListIonizers extends ListRecords
{
    protected static string $resource = IonizerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('customAction')
                ->url('/esd/ionizer-details')
                ->label('Go To All Measurement Of Ionizer')
                ->color('success')
        ];
    }
}
