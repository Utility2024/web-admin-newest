<?php

namespace App\Filament\MainMenu\Resources\InboxResource\Pages;

use App\Filament\MainMenu\Resources\InboxResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInbox extends ViewRecord
{
    protected static string $resource = InboxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
