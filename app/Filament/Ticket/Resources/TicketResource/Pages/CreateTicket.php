<?php

namespace App\Filament\Ticket\Resources\TicketResource\Pages;

use App\Filament\Ticket\Resources\TicketResource;
use Filament\Resources\Pages\CreateRecord;
use App\Mail\TicketCreated;
use App\Mail\TicketCreatedForUser;
use Illuminate\Support\Facades\Mail;
use App\Models\Ticket;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Ticket Created')
                ->body('The Ticket has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $ticket = $this->record;

        // Create and send the notification email to a default address
        Mail::to('widifajarsatritama@gmail.com')->send(new TicketCreated($ticket));

        // Determine the email to send based on assigned_role
        $emailToSend = null;
        switch ($ticket->assigned_role) {
            case 'ADMINUTILITY':
                $emailToSend = 'sek.ticketing@gmail.com';
                break;
            case 'ADMINESD':
                $emailToSend = 'if22.widisatritama@mhs.ubpkarawang.ac.id';
                break;
        }

        // Send email to the determined address if set
        if ($emailToSend) {
            Mail::to($emailToSend)->send(new TicketCreated($ticket));
        }

        // Send email to the user who created the ticket
        if ($ticket->email_user) {
            Mail::to($ticket->email_user)->send(new TicketCreatedForUser($ticket)); // Use the new Mailable
        }

        Notification::make()
            ->success()
            ->title('Ticket Created')
            ->body("The Ticket for No {$ticket->ticket_number} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(TicketResource::getUrl('view', ['record' => $ticket])),
            ])
            ->sendToDatabase(\auth()->user());
    }


}


