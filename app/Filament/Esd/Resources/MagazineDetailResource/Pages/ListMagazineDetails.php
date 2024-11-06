<?php

namespace App\Filament\Esd\Resources\MagazineDetailResource\Pages;

use App\Filament\Esd\Resources\MagazineDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMagazineDetails extends ListRecords
{
    protected static string $resource = MagazineDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
