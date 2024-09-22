<?php

namespace App\Filament\Ticket\Resources\TicketResource\Pages;

use App\Filament\Ticket\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    // protected function mutateFormDataBeforeFill(array $data): array
    // {
    //     // Check if the current user is the creator of the ticket
    //     if ($data['created_by'] !== Auth::id()) {
    //         abort(403, 'You do not have permission to edit this ticket.');
    //     }

    //     return $data;
    // }
}
