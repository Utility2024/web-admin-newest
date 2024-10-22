<?php

namespace App\Filament\Ticket\Resources\TicketResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Ticket;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\RelationManagers\RelationManager;

class FeedbackRelationManager extends RelationManager
{
    protected static string $relationship = 'feedbacks';
    
    protected static ?string $recordTitleAttribute = 'content';

    public function form(Form $form): Form
    {
        $ticketId = session('ticket_id');
        $user = Auth::user();

        // Menyembunyikan atau menonaktifkan beberapa komponen jika pengguna adalah isUser
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('ticket_id')
                            ->relationship('ticket', 'ticket_number')
                            ->required()
                            ->searchable()
                            ->label('Ticket')
                            ->reactive()
                            ->default($ticketId)
                            ->extraAttributes(['style' => 'pointer-events: none;'])
                            ->afterStateUpdated(function (callable $set, $state) {
                                $ticket = \App\Models\Ticket::find($state);
                                if ($ticket) {
                                    $set('status', $ticket->status);
                                }
                            }),
                        
                        Forms\Components\ToggleButtons::make('status')
                            ->options([
                                'Open' => 'Open',
                                'In Progress' => 'In Progress',
                                'Pending' => 'Pending',
                                'Closed' => 'Closed',
                            ])
                            ->colors([
                                'Open' => 'info',
                                'In Progress' => 'warning',
                                'Pending' => 'danger',
                                'Closed' => 'success',
                            ])
                            ->inline()
                            ->default('Open')
                            ->required()
                            ->label('Status')
                            ->reactive()
                            ->afterStateUpdated(function ($state) {
                                $ticket = \App\Models\Ticket::find(session('ticket_id'));
                                if ($ticket) {
                                    $ticket->status = $state;
                                    $ticket->save();
                                }
                            }),
                        
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->label('Name')
                            ->default(Auth::id())
                            ->extraAttributes(['style' => 'pointer-events: none;'])
                            ->hidden($user->isUser()),  // Sembunyikan jika pengguna adalah isUser
                        
                        Forms\Components\Textarea::make('comments')
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull(),
                            
                        Forms\Components\FileUpload::make('photo')
                            ->disk('public')
                            ->label('Photo')
                            ->image()
                    ])
                ]);
    }

    public function table(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->recordTitleAttribute('comments')
            ->columns([
                Tables\Columns\TextColumn::make('comments')
                    ->label('Comments'),

                Tables\Columns\TextColumn::make('user.name'),
                
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Open' => 'danger',
                        'In Progress' => 'warning',
                        'Pending' => 'danger',
                        'Closed' => 'success',
                    })
                    ->label('Status'),
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo')
                    ->size(100)
                    ->disk('public'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Created At'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Updated At'),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions($user->isUser() ? [] : [
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions($user->isUser() ? [] : [
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
