<?php

namespace App\Filament\Esd\Resources\FlooringResource\Pages;

use App\Filament\Esd\Resources\FlooringResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFlooring extends ViewRecord
{
    protected static string $resource = FlooringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
