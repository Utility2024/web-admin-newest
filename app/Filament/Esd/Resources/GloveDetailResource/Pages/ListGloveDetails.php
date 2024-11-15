<?php

namespace App\Filament\Esd\Resources\GloveDetailResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Esd\Resources\GloveDetailResource;
use App\Filament\Esd\Resources\GloveDetailResource\Widgets\StandartGlove;
use App\Filament\Esd\Resources\GloveDetailResource\Widgets\GloveDetailStatsOverview;

class ListGloveDetails extends ListRecords
{
    protected static string $resource = GloveDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // GloveDetailStatsOverview::class,
            StandartGlove::class,
        ];
    }
}
