<?php

namespace App\Filament\Wh\Resources\MasterRackResource\Pages;

use App\Filament\Wh\Resources\MasterRackResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasterRacks extends ListRecords
{
    protected static string $resource = MasterRackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // Change this method to be non-static
    public function getTitle(): string
    {
        return "Locator";
    }
}
