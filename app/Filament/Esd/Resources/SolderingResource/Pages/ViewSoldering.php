<?php

namespace App\Filament\Esd\Resources\SolderingResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Esd\Resources\SolderingResource;
use App\Filament\Esd\Resources\SolderingResource\RelationManagers\SolderingDetailRelationManager;

class ViewSoldering extends ViewRecord
{
    protected static string $resource = SolderingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getRelationManagers(): array
    {
        return [
            SolderingDetailRelationManager::class,
            
        ];
    }
}
