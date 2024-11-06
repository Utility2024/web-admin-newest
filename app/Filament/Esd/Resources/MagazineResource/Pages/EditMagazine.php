<?php

namespace App\Filament\Esd\Resources\MagazineResource\Pages;

use App\Filament\Esd\Resources\MagazineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMagazine extends EditRecord
{
    protected static string $resource = MagazineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
