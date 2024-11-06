<?php

namespace App\Filament\Esd\Resources\JigDetailResource\Pages;

use App\Filament\Esd\Resources\JigDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJigDetails extends ListRecords
{
    protected static string $resource = JigDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
