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
use Illuminate\Support\Facades\Mail; // Don't forget to import Mail
use App\Mail\FeedbackCreated;
use Filament\Notifications\Notification; // Import the FeedbackCreated Mailable

class FeedbackRelationManager extends RelationManager
{
    protected static string $relationship = 'feedbacks';
    
    protected static ?string $recordTitleAttribute = 'content';

    public function form(Form $form): Form
    {
        $ticketId = session('ticket_id');
        $user = Auth::user();

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
                        
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->label('Name')
                            ->default(Auth::id())
                            ->extraAttributes(['style' => 'pointer-events: none;'])
                            ->hidden($user->isUser()),

                        Forms\Components\Select::make('email_user')
                            ->relationship('ticket', 'email_user')
                            ->required()
                            ->searchable()
                            ->label('Email User')
                            ->reactive()
                            ->default($ticketId)
                            ->extraAttributes(['style' => 'pointer-events: none;'])
                            ->afterStateUpdated(function (callable $set, $state) {
                                $ticket = \App\Models\Ticket::find($state);
                                if ($ticket) {
                                    $set('email_user', $ticket->email_user);
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
                Tables\Columns\TextColumn::make('comments')->label('Comments'),
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
                // Add filters if needed
            ])
            ->headerActions($user->isUser() ? [] : [
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

    protected function getCreatedNotification(): ?Notification
    {
        return 
            Notification::make()
                ->success()
                ->title('Feedback Created')
                ->body('The Feedback Ticket has been created successfully.');
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
