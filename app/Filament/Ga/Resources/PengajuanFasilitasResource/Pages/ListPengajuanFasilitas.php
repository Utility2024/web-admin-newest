<?php

namespace App\Filament\Ga\Resources\PengajuanFasilitasResource\Pages;

use App\Filament\Ga\Resources\PengajuanFasilitasResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Ga\Resources\PengajuanFasilitasResource\Widgets\WarningFacility;

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

    protected function getTableQuery(): ?Builder
    {
        // Dapatkan pengguna yang sedang autentikasi
        $user = auth()->user();

        // Cek apakah pengguna adalah Super Admin
        if ($user->isSuperAdmin()) {
            return parent::getTableQuery(); // Tampilkan semua data
        }

        // Filter data berdasarkan field created_by
        return parent::getTableQuery()->where('created_by', $user->id);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // WorksurfaceDetailStatsOverview::class,
            WarningFacility::class,
        ];
    }
}
