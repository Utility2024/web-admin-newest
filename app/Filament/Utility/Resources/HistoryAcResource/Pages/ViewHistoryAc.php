<?php

namespace App\Filament\Utility\Resources\HistoryAcResource\Pages;

use App\Filament\Utility\Resources\HistoryAcResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHistoryAc extends ViewRecord
{
    protected static string $resource = HistoryAcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
