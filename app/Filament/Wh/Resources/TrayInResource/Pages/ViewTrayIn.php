<?php

namespace App\Filament\Wh\Resources\TrayInResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Wh\Resources\TrayInResource;

class ViewTrayIn extends ViewRecord
{
    protected static string $resource = TrayInResource::class;

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
