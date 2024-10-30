<?php

namespace App\Filament\Esd\Resources\FlooringDetailResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Esd\Resources\FlooringDetailResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\FlooringCreated;

class CreateFlooringDetail extends CreateRecord
{
    protected static string $resource = FlooringDetailResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Flooring Meaurement')
                ->body('The Flooring Meaurement has been created successfully.');
    }

    protected function afterCreate(): void
    {
        $flooring = $this->record;
    
        // Create and send the notification email
        Mail::to('widifajarsatritama@gmail.com')->send(new FlooringCreated($flooring));
    
        Notification::make()
            ->success()
            ->title('Master Flooring')
            ->body("The Flooring for register no {$flooring->register_no} has been created successfully.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(FlooringDetailResource::getUrl('view', ['record' => $flooring])),
            ])
            ->sendToDatabase(\auth()->user());
    }
}
