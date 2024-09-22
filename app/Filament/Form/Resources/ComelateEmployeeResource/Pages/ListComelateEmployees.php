<?php

namespace App\Filament\Form\Resources\ComelateEmployeeResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Form\Resources\ComelateEmployeeResource;

class ListComelateEmployees extends ListRecords
{
    protected static string $resource = ComelateEmployeeResource::class;

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

    public function getTitle():string
    {
        return "History Comelate";
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make()
                ->badge($this->getCount()) // Add badge with the total count
                ->modifyQueryUsing(fn (Builder $query) => $query->where('created_by', auth()->id())),

            'Macet Lalulintas' => Tab::make()
                ->badge($this->getCount('Macet Lalulintas'))
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('alasan_terlambat', 'Macet Lalulintas')
                          ->where('created_by', auth()->id())
                ),

            'Masalah Kendaraan' => Tab::make()
                ->badge($this->getCount('Masalah Kendaraan'))
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('alasan_terlambat', 'Masalah Kendaraan')
                          ->where('created_by', auth()->id())
                ),

            'Telat Berangkat' => Tab::make()
                ->badge($this->getCount('Telat Berangkat'))
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('alasan_terlambat', 'Telat Berangkat')
                          ->where('created_by', auth()->id())
                ),

            'Keperluan Pribadi' => Tab::make()
                ->badge($this->getCount('Keperluan Pribadi'))
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('alasan_terlambat', 'Keperluan Pribadi')
                          ->where('created_by', auth()->id())
                ),

            'Keperluan Keluarga' => Tab::make()
                ->badge($this->getCount('Keperluan Keluarga'))
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->where('alasan_terlambat', 'Keperluan Keluarga')
                          ->where('created_by', auth()->id())
                ),
        ];
    }

    private function getCount(string $reason = null): int
    {
        $query = $this->getResource()::getModel()::query()
            ->where('created_by', auth()->id()); // Filter by logged-in user

        if ($reason) {
            $query->where('alasan_terlambat', $reason);
        }

        return $query->count();
    }
}
