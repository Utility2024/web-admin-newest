<?php

namespace App\Filament\Form\Resources\PengajuanFasilitasResource\Pages;

use App\Filament\Form\Resources\PengajuanFasilitasResource;
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
