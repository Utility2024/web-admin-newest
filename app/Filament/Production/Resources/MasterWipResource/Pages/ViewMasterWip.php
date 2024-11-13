<?php

namespace App\Filament\Production\Resources\MasterWipResource\Pages;

use App\Filament\Production\Resources\MasterWipResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ViewMasterWip extends ViewRecord
{
    protected static string $resource = MasterWipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            // Approval Action
            Actions\Action::make('updateApproval')
                ->label('Approve')
                ->button()
                ->action(function ($record) {
                    // Only proceed if the user is authorized to approve
                    if (!auth()->user()->isAdminWip()) {
                        Notification::make()
                            ->title('Unauthorized Action')
                            ->body('You are not authorized to approve this WIP.')
                            ->danger()
                            ->send();

                        return;
                    }

                    // Check if the current approval status is already 'Approved'
                    if ($record->approval === 'Approved') {
                        Notification::make()
                            ->title('No Action Needed')
                            ->body('The approval status is already set to "Approved".')
                            ->danger()
                            ->send();

                        return; // Exit the action early if the status is already 'Approved'
                    }

                    // Update the approval status
                    $newApproval = 'Approved';

                    $record->update([
                        'approval' => $newApproval,
                        'updated_by' => Auth::id(), // Set updated_by to the authenticated user's ID
                    ]);

                    Notification::make()
                        ->title('Approval Updated')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->hidden(fn ($record) => !auth()->user()->isAdminWip() || $record->approval === 'Approved') // Hide if not admin or already approved
                ->color('success'),
            
            // Accept Action
            Actions\Action::make('updateAcceptanceStatus')
                ->label('Accept')
                ->button()
                ->action(function ($record) {
                    // Only proceed if the user is authorized to accept
                    if (!auth()->user()->isUserWip()) {
                        Notification::make()
                            ->title('Unauthorized Action')
                            ->body('You are not authorized to accept this WIP.')
                            ->danger()
                            ->send();

                        return;
                    }

                    // Check if the current acceptance status is already 'Accepted'
                    if ($record->acceptance_status === 'Accepted') {
                        Notification::make()
                            ->title('No Action Needed')
                            ->body('The acceptance status is already set to "Accepted".')
                            ->danger()
                            ->send();

                        return; // Exit the action early if the status is already 'Accepted'
                    }

                    // Update the acceptance status and set the updated_by to the authenticated user's ID
                    $newStatus = 'Accepted';

                    $record->update([
                        'acceptance_status' => $newStatus,
                        'updated_by' => Auth::id(), // Set updated_by to the authenticated user's ID
                    ]);

                    Notification::make()
                        ->title('Status Updated')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->hidden(fn ($record) => !auth()->user()->isUserWip() || $record->acceptance_status === 'Accepted') // Hide if not user or already accepted
                ->color('success'),
        ];
    }
}
