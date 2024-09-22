<?php

namespace App\Filament\Ticket\Resources\CategoryTicketResource\Pages;

use App\Filament\Ticket\Resources\CategoryTicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCategoryTicket extends ViewRecord
{
    protected static string $resource = CategoryTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
