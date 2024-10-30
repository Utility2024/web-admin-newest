<?php

namespace App\Filament\Ticket\Resources\FeedbackResource\Pages;

use App\Filament\Ticket\Resources\FeedbackResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackCreated;

class CreateFeedback extends CreateRecord
{
    protected static string $resource = FeedbackResource::class;

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
        $feedback = $this->record; // Get the created feedback

        // Send the feedback notification email to the user
        if ($feedback->email_user) {
            Mail::to($feedback->email_user)->send(new FeedbackCreated($feedback));
        }

        // Send the feedback email to the specific address
        Mail::to('widifajarsatritama@gmail.com')->send(new FeedbackCreated($feedback));

        Notification::make()
            ->success()
            ->title('Feedback Created')
            ->body("Your feedback has been created successfully.")
            ->sendToDatabase(\auth()->user());
    }
}
