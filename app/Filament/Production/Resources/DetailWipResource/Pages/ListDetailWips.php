<?php

namespace App\Filament\Production\Resources\DetailWipResource\Pages;

use App\Filament\Production\Resources\DetailWipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetailWips extends ListRecords
{
    protected static string $resource = DetailWipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Data All Transaksi WIP";
    }
}
