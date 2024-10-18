<?php

namespace App\Filament\Ga\Resources\PengajuanFasilitasResource\Pages;

use App\Filament\Ga\Resources\PengajuanFasilitasResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPengajuanFasilitas extends ViewRecord
{
    protected static string $resource = PengajuanFasilitasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
}
