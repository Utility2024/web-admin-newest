<?php

namespace App\Filament\Esd\Resources\MagazineResource\Pages;

use App\Filament\Esd\Resources\MagazineResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMagazine extends ViewRecord
{
    protected static string $resource = MagazineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
