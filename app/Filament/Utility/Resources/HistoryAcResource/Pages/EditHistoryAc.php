<?php

namespace App\Filament\Utility\Resources\HistoryAcResource\Pages;

use App\Filament\Utility\Resources\HistoryAcResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHistoryAc extends EditRecord
{
    protected static string $resource = HistoryAcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
