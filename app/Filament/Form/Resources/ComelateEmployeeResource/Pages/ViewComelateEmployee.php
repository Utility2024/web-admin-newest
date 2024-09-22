<?php

namespace App\Filament\Form\Resources\ComelateEmployeeResource\Pages;

use App\Filament\Form\Resources\ComelateEmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewComelateEmployee extends ViewRecord
{
    protected static string $resource = ComelateEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
