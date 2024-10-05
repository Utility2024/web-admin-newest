<?php

namespace App\Filament\Esd\Resources\WorksurfaceResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Esd\Resources\WorksurfaceResource;

class ListWorksurfaces extends ListRecords
{
    protected static string $resource = WorksurfaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('customAction')
                ->url('/esd/worksurface-details')
                ->label('Go To All Measurement Of Worksurface')
                ->color('success')
        ];
    }
}
