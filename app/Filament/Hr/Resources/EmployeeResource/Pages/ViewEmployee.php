<?php

namespace App\Filament\Hr\Resources\EmployeeResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Hr\Resources\EmployeeResource;
use App\Filament\Hr\Resources\EmployeeResource\Widgets\CountComelate;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
}
