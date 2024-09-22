<?php

namespace App\Filament\Ticket\Resources\TicketResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Ticket\Resources\TicketResource;
use App\Filament\Ticket\Resources\TicketResource\RelationManagers\FeedbackRelationManager;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->hidden(fn ($record) => in_array($record->status, ['In Progress', 'Closed'])),
        ];
    }

    // Menambahkan action di bagian bawah (footer)
    protected function getFooterActions(): array
    {
        return [
            Actions\Action::make('approve_user')
                ->label('Approval User')
                ->form([
                    Forms\Components\ToggleButtons::make('approval_status')
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
                    Forms\Components\Textarea::make('comments')
                        ->label('Comments')
                        ->required(),
                ])
                ->icon('heroicon-o-check-badge')
                ->action(function (array $data, Ticket $record): void {
                    $user = Auth::user();
                    if ($user->id === $record->created_by) {
                        $record->approval_user = $data['approval_status'];
                        $record->approval_user_at = now();
                        $record->save();
                    }
                })
                ->hidden(fn ($record) => $record->approval !== 'Approved' && $record->approval !== 'Rejected' || Auth::user()->id !== $record->created_by),
        ];
    }
}
