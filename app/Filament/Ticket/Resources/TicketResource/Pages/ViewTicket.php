<?php

namespace App\Filament\Ticket\Resources\TicketResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Ticket\Resources\TicketResource;
use App\Filament\Ticket\Resources\TicketResource\RelationManagers\FeedbackRelationManager;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    public function getRelationManagers(): array
    {
        return [
            FeedbackRelationManager::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->hidden(fn ($record) => in_array($record->status, ['In Progress', 'Closed'])),
        ];
    }
}
