<?php

namespace App\Filament\Utility\Resources\AcResource\Pages;

use App\Filament\Utility\Resources\AcResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcs extends ListRecords
{
    protected static string $resource = AcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Data All AC";
    }
}
