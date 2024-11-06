<?php

namespace App\Filament\Esd\Resources\MagazineDetailResource\Pages;

use App\Filament\Esd\Resources\MagazineDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMagazineDetail extends EditRecord
{
    protected static string $resource = MagazineDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
