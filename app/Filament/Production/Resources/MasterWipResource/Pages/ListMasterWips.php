<?php

namespace App\Filament\Production\Resources\MasterWipResource\Pages;

use App\Filament\Production\Resources\MasterWipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListMasterWips extends ListRecords
{
    protected static string $resource = MasterWipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Master Transfer WIP";
    }

    public function getTabs(): array
    {
        $tabs = [];

        // Add status-based tabs for all users
        $tabs['All'] = Tab::make()
            ->badge($this->getCount()) // Total count of all records
            ->modifyQueryUsing(fn (Builder $query) => $query);

        $tabs['Open'] = Tab::make()
            ->badge($this->getCountByStatus('Open'))
            ->icon('heroicon-m-arrow-right-start-on-rectangle')
            ->badgeColor('danger')
            ->modifyQueryUsing(fn (Builder $query) => 
                $query->where('status', 'Open')
            );

        $tabs['In Progress'] = Tab::make()
            ->badge($this->getCountByStatus('In Progress'))
            ->badgeColor('info')
            ->icon('heroicon-m-backward')
            ->modifyQueryUsing(fn (Builder $query) => 
                $query->where('status', 'In Progress')
            );

        $tabs['Finished'] = Tab::make()
            ->badge($this->getCountByStatus('Finished'))
            ->badgeColor('success')
            ->icon('heroicon-m-check-circle')
            ->modifyQueryUsing(fn (Builder $query) => 
                $query->where('status', 'Closed')
            );

        return $tabs;
    }

    private function getCount(): int
    {
        return $this->getResource()::getModel()::count();
    }

    private function getCountByStatus(string $status): int
    {
        return $this->getResource()::getModel()::where('status', $status)->count();
    }
}
