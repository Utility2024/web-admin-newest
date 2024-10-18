<?php

namespace App\Filament\Hr\Resources\ComelateEmployeeResource\Pages;

use App\Filament\Hr\Resources\ComelateEmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Ga\Resources\PengajuanFasilitasResource\Widgets\WarningFacility;

class ListComelateEmployees extends ListRecords
{
    protected static string $resource = ComelateEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // WorksurfaceDetailStatsOverview::class,
            WarningFacility::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make()
                ->badge($this->getCount()),// Add badge with the total count
                // ->label("All ({$this->getCount()})"),

            'Macet Lalulintas' => Tab::make()
                ->badge($this->getCount('Macet Lalulintas'))
                // ->label("Macet Lalulintas ({$this->getCount('Macet Lalulintas')})")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('alasan_terlambat', 'Macet Lalulintas')),

            'Masalah Kendaraan' => Tab::make()
                ->badge($this->getCount('Masalah Kendaraan'))
                // ->label("Masalah Kendaraan ({$this->getCount('Masalah Kendaraan')})")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('alasan_terlambat', 'Masalah Kendaraan')),

            'Telat Berangkat' => Tab::make()
                ->badge($this->getCount('Telat Berangkat'))
                // ->label("Telat Berangkat ({$this->getCount('Telat Berangkat')})")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('alasan_terlambat', 'Telat Berangkat')),

            'Keperluan Pribadi' => Tab::make()
                ->badge($this->getCount('Keperluan Pribadi'))
                // ->label("Keperluan Pribadi ({$this->getCount('Keperluan Pribadi')})")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('alasan_terlambat', 'Keperluan Pribadi')),

            'Keperluan Keluarga' => Tab::make()
                ->badge($this->getCount('Keperluan Keluarga'))
                // ->label("Keperluan Keluarga ({$this->getCount('Keperluan Keluarga')})")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('alasan_terlambat', 'Keperluan Keluarga')),
        ];
    }

    private function getCount(string $reason = null): int
    {
        $query = $this->getResource()::getModel()::query();

        if ($reason) {
            $query->where('alasan_terlambat', $reason);
        }

        return $query->count();
    }
}
