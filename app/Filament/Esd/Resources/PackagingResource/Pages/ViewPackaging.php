<?php

namespace App\Filament\Esd\Resources\PackagingResource\Pages;

use App\Filament\Esd\Resources\PackagingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPackaging extends ViewRecord
{
    protected static string $resource = PackagingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
             // Menambahkan tombol Add Action di header
        ];
    }
}
