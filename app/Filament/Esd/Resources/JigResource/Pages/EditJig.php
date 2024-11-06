<?php

namespace App\Filament\Esd\Resources\JigResource\Pages;

use App\Filament\Esd\Resources\JigResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJig extends EditRecord
{
    protected static string $resource = JigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
