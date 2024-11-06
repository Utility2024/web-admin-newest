<?php

namespace App\Filament\Esd\Resources\JigDetailResource\Pages;

use App\Filament\Esd\Resources\JigDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJigDetail extends EditRecord
{
    protected static string $resource = JigDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
