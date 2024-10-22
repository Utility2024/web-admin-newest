<?php

namespace App\Filament\Ticket\Resources\TicketResource\Pages;

use App\Filament\Ticket\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Ticket\Resources\TicketResource\RelationManagers\FeedbackRelationManager;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    public function getRelationManagers(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
