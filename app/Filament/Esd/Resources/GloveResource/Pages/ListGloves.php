<?php

namespace App\Filament\Esd\Resources\GloveResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Esd\Resources\GloveResource;

class ListGloves extends ListRecords
{
    protected static string $resource = GloveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('customAction')
                ->url('/esd/glove-details')
                ->label('Go To All Measurement Of Glove')
                ->color('success')
        ];
    }
}
