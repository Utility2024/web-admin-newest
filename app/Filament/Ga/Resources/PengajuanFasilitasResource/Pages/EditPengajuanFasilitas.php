<?php

namespace App\Filament\Ga\Resources\PengajuanFasilitasResource\Pages;

use App\Filament\Ga\Resources\PengajuanFasilitasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanFasilitas extends EditRecord
{
    protected static string $resource = PengajuanFasilitasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
