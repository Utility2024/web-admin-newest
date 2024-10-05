<?php

namespace App\Filament\Wh\Resources\TrayStockResource\Pages;

use App\Filament\Wh\Resources\TrayStockResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTrayStock extends ViewRecord
{
    protected static string $resource = TrayStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
