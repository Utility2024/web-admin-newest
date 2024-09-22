<?php

namespace App\Filament\Form\Resources\PengajuanFasilitasResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Form\Resources\PengajuanFasilitasResource;

class ListPengajuanFasilitas extends ListRecords
{
    protected static string $resource = PengajuanFasilitasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('customAction')
                ->label('Back To Menu')
                ->icon('heroicon-o-arrow-left-start-on-rectangle')
                ->color('danger')
                ->url('http://portal.siix-ems.co.id/form'),
        ];
    }
}
