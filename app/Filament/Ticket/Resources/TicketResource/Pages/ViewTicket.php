<?php

namespace App\Filament\Ticket\Resources\TicketResource\Pages;

use Filament\Forms;
use App\Models\User;
use Filament\Actions;
use App\Models\Ticket;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ViewRecord;
use RelationManagers\FeedbackRelationManager;
use App\Filament\Ticket\Resources\TicketResource;
use App\Models\Feedback; // Import the Feedback model

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    public static function getRelations(): array
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
