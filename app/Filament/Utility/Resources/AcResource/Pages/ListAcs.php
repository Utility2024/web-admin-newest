<?php

namespace App\Filament\Utility\Resources\AcResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Utility\Resources\AcResource;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAcs extends ListRecords
{
    protected static string $resource = AcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Data All AC";
    }

    public function getTabs(): array
    {
        return [

            'All' => Tab::make()
                ->badge($this->getCount()),
                
            'OK' => Tab::make()
                ->icon('heroicon-o-check-circle')
                ->badge($this->getCount('OK'))
                ->badgeColor('success') // Set badge color to success (green)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'OK')),

            'NG' => Tab::make()
                ->icon('heroicon-o-x-circle')
                ->badge($this->getCount('NG'))
                ->badgeColor('danger') // Set badge color to danger (red)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'NG')),
        ];
    }



    private function getCount(string $reason = null): int
    {
        $query = $this->getResource()::getModel()::query();

        if ($reason) {
            $query->where('status', $reason);
        }

        return $query->count();
    }
}
