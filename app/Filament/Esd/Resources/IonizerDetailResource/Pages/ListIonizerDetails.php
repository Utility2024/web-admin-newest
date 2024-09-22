<?php

namespace App\Filament\Esd\Resources\IonizerDetailResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Esd\Resources\IonizerDetailResource;
use App\Filament\Esd\Resources\IonizerDetailResource\Widgets\StandartIonizer;

class ListIonizerDetails extends ListRecords
{
    protected static string $resource = IonizerDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StandartIonizer::class,
        ];
    }
}
