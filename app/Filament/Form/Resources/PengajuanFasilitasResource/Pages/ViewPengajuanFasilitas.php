<?php

namespace App\Filament\Form\Resources\PengajuanFasilitasResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Form\Resources\PengajuanFasilitasResource;

class ViewPengajuanFasilitas extends ViewRecord
{
    protected static string $resource = PengajuanFasilitasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
            Action::make('customAction')
                ->label('Back')
                ->color('danger')
                ->url('/form/pengajuan-fasilitas'),
        ];
    }
}
