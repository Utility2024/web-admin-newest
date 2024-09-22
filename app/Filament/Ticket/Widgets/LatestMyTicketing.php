<?php

namespace App\Filament\Ticket\Widgets;

use Filament\Tables;
use App\Models\Ticket;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMyTicketing extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Latest Ticket';

    public function table(Table $table): Table
    {
        $user = Auth::user(); // Get the currently authenticated user
        $query = Ticket::query();

        // Custom query based on user role
        if ($user->isUser()) {
            // If the user is 'isUser', only show tickets they created
            $query->where('created_by', $user->id);
        } elseif ($user->isManagerAdmin() || $user->isSuperAdmin()) {
            // If the user is 'isManagerAdmin' or 'isSuperAdmin', show all tickets
            // No filtering needed as they can see everything
        } elseif ($user->isAdminHr()) {
            // If the user is 'isAdminHr', only show tickets assigned to HR
            $query->where('assigned_role', 'ADMINHR');
        } elseif ($user->isAdminEsd()) {
            // If the user is 'isAdminEsd', only show tickets assigned to ESD
            $query->where('assigned_role', 'ADMINESD');
        } elseif ($user->isAdminGa()) {
            // If the user is 'isAdminGa', only show tickets assigned to GA
            $query->where('assigned_role', 'ADMINGA');
        } elseif ($user->isAdminUtility()) {
            // If the user is 'isAdminUtility', only show tickets assigned to Utility
            $query->where('assigned_role', 'ADMINUTILITY');
        }

        return $table
            ->query(
                $query->latest() // Order by the most recent tickets
            )
            ->columns([
                Tables\Columns\TextColumn::make('ticket_number')
                    ->label('Ticket Number')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Open' => 'danger',
                        'In Progress' => 'warning',
                        'Pending' => 'primary',
                        'Closed' => 'success',
                    }),

                Tables\Columns\TextColumn::make('priority')
                    ->label('Priority')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Low' => 'info',
                        'Medium' => 'warning',
                        'Urgent' => 'danger',
                        'Critical' => 'primary'
                    }),

                Tables\Columns\TextColumn::make('assigned_role')
                    ->label('Assigned To Section')
                    ->formatStateUsing(function ($state) {
                        $roleMapping = [
                            'ADMINESD' => 'ESD (Electrostatic Discharge)',
                            'ADMINUTILITY' => 'Facility & Utility',
                            'ADMINHR' => 'HR (Human Resource)',
                            'ADMINGA' => 'GA (General Affair)',
                        ];
                        return $roleMapping[$state] ?? $state;
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('customAction')
                    ->label('Add New Ticket')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->url('http://portal.siix-ems.co.id/ticket/tickets/create')
                    ->visible(fn () => auth()->user()->isUser()) // Only visible if the user is 'isUser'
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Ticket $record): string => "http://portal.siix-ems.co.id/ticket/tickets/{$record->id}")
                    ->label('View')
            ]);
    }
}
