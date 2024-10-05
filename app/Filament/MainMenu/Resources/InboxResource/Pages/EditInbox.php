<?php

namespace App\Filament\MainMenu\Resources\InboxResource\Pages;

use App\Filament\MainMenu\Resources\InboxResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInbox extends EditRecord
{
    protected static string $resource = InboxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
