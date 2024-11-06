<?php

namespace App\Filament\Esd\Resources\JigResource\Pages;

use App\Filament\Esd\Resources\JigResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJigs extends ListRecords
{
    protected static string $resource = JigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
