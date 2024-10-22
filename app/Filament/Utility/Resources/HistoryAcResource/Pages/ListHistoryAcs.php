<?php

namespace App\Filament\Utility\Resources\HistoryAcResource\Pages;

use App\Filament\Utility\Resources\HistoryAcResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHistoryAcs extends ListRecords
{
    protected static string $resource = HistoryAcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "History Of AC";
    }
}
