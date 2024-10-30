<?php

namespace App\Filament\Ticket\Resources\TicketResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Ticket\Resources\TicketResource;
use App\Filament\Ticket\Resources\TicketResource\RelationManagers\FeedbackRelationManager;
use Illuminate\Support\Facades\Auth; // Make sure to include Auth for user role checks
use Filament\Notifications\Notification;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Textarea; // Make sure to include Notification

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
        $actions = [
            Actions\EditAction::make()
                ->hidden(fn ($record) => 
                    in_array($record->status, ['In Progress', 'Pending', 'Closed']) || 
                    $record->created_at < now()->subHours(24)
                ),
        ];

        $record = $this->record; // Get the current record

        // Approval User Action
        if (Auth::user()->isUser() && $record->approval_user !== 'Approved') {
            $actions[] = Actions\Action::make('approve_user')
                ->button()
                ->color('success')
                ->label('Approval User')
                ->form([
                    ToggleButtons::make('approval_status')
                        ->label('Approval Status')
                        ->options([
                            'Approved' => 'Approved',
                            'Rejected' => 'Rejected',
                        ])
                        ->colors([
                            'Approved' => 'success',
                            'Rejected' => 'danger',
                        ])
                        ->inline()
                        ->required(),
                    Textarea::make('comment_user')
                        ->label('Comments')
                        ->required(),
                ])
                ->icon('heroicon-o-check-badge')
                ->action(function (array $data) use ($record) {
                    $record->approval_user = $data['approval_status'];
                    $record->approval_user_at = now();
                    $record->comment_user = $data['comment_user'] ?? $record->comments;
                    $record->save();

                    // Optional: Add notification if necessary
                    Notification::make()
                        ->title('Approval User Updated')
                        ->success()
                        ->send();
                });
        }

        // Approval Manager Action
        if (Auth::user()->isManagerAdmin() && $record->approval !== 'Approved') {
            $actions[] = Actions\Action::make('approve')
                ->button()
                ->label('Approval')
                ->form([
                    ToggleButtons::make('approval_status')
                        ->label('Approval Status')
                        ->options([
                            'Approved' => 'Approved',
                            'Rejected' => 'Rejected',
                        ])
                        ->colors([
                            'Approved' => 'success',
                            'Rejected' => 'danger',
                        ])
                        ->inline()
                        ->required(),
                    Textarea::make('comment_manager')
                        ->label('Comments')
                        ->required(),
                ])
                ->icon('heroicon-o-check-badge')
                ->action(function (array $data) use ($record) {
                    $record->approval = $data['approval_status'];
                    $record->approval_at = now();
                    $record->comment_manager = $data['comment_manager'] ?? $record->comments;
                    $record->save();
                });
        }

        return $actions;
    }
}
