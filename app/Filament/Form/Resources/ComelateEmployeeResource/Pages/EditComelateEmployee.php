<?php

namespace App\Filament\Form\Resources\ComelateEmployeeResource\Pages;

use App\Filament\Form\Resources\ComelateEmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComelateEmployee extends EditRecord
{
    protected static string $resource = ComelateEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
