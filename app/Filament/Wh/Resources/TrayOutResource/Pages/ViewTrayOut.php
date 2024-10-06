<?php

namespace App\Filament\Wh\Resources\TrayOutResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Wh\Resources\TrayOutResource;

class ViewTrayOut extends ViewRecord
{
    protected static string $resource = TrayOutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('customAction')
                ->label('Back To Tray Stock')
                ->icon('heroicon-o-arrow-left-end-on-rectangle')
                ->color('danger')
                ->url('/wh/tray-stocks'),
        ];
    }
}
