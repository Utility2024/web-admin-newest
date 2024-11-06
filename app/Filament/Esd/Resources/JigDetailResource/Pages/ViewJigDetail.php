<?php

namespace App\Filament\Esd\Resources\JigDetailResource\Pages;

use App\Filament\Esd\Resources\JigDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewJigDetail extends ViewRecord
{
    protected static string $resource = JigDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
