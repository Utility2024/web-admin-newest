<?php

namespace App\Filament\Wh\Resources\TrayStockResource\Pages;

use App\Filament\Wh\Resources\TrayStockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrayStock extends EditRecord
{
    protected static string $resource = TrayStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
