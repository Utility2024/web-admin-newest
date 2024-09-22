<?php

namespace App\Filament\Ga\Resources\PengajuanFasilitasResource\Pages;

use App\Filament\Ga\Resources\PengajuanFasilitasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengajuanFasilitas extends ListRecords
{
    protected static string $resource = PengajuanFasilitasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
