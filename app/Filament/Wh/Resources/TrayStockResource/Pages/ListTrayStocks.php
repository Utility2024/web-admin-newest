<?php

namespace App\Filament\Wh\Resources\TrayStockResource\Pages;

use App\Filament\Wh\Resources\TrayStockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;

class ListTrayStocks extends ListRecords
{
    protected static string $resource = TrayStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle'),
            Action::make('customAction')
                ->label('Add Tray In')
                ->icon('heroicon-o-arrow-left-end-on-rectangle')
                ->color('success')
                ->url('/wh/tray-ins/create'),
            Action::make('customAction')
                ->label('Add Tray Out')
                ->icon('heroicon-o-arrow-right-start-on-rectangle')
                ->color('danger')
                ->url('/wh/tray-outs/create'),
        ];
    }
}
