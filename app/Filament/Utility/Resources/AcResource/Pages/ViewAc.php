<?php

namespace App\Filament\Utility\Resources\AcResource\Pages;

use App\Filament\Utility\Resources\AcResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAc extends ViewRecord
{
    protected static string $resource = AcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
