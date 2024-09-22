<?php

namespace App\Filament\Ticket\Resources\CategoryTicketResource\Pages;

use App\Filament\Ticket\Resources\CategoryTicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryTicket extends EditRecord
{
    protected static string $resource = CategoryTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
