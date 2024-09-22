<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Feedback;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Card as InfolistCard;
use App\Filament\Resources\FeedbackResource\Pages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Ticketing';

    public static function canViewNavigation(): bool
    {
        // Check if the user has the 'isSuperAdmin' role
        return Gate::allows('view-feedback-navigation');
    }

    public static function form(Form $form): Form
    {
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
                            ->afterStateUpdated(function (callable $set, $state) {
                                $ticket = \App\Models\Ticket::find($state); // Assuming you have a Ticket model
                                if ($ticket) {
                                    $set('status', $ticket->status); // Assuming `status` is a column on the Ticket model
                                }
                            }),

                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->label('User'),
                        
                        Forms\Components\ToggleButtons::make('status')
                            ->options([
                                'Open' => 'Open',
                                'In Progress' => 'In Progress',
                                'Closed' => 'Closed',
                            ])
                            ->colors([
                                'Open' => 'info',
                                'In Progress' => 'warning',
                                'Closed' => 'success',
                            ])
                            ->inline()
                            ->default('Open')
                            ->required()
                            ->label('Status')
                            ->reactive(),
                            // ->afterStateHydrated(function ($component, $state) {
                            //     if ($state === 'Closed') {
                            //         $component->disabled();
                            //     }
                            // })
                            // ->disabled(fn ($get) => $get('status') === 'Closed'),
                        
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


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('ticket.ticket_number')
                        ->label('Ticket Number'),
                    TextEntry::make('user.name')
                        ->label('User'),
                    TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'Open' => 'danger',
                            'In Progress' => 'warning',
                            'Closed' => 'success',
                        })
                        ->label('Status'),
                    TextEntry::make('comments')
                        ->label('Comments'),
                ])->columns(2),
                InfolistCard::make([
                    ImageEntry::make('photo')
                        ->label('Photo'),
                    TextEntry::make('created_at')
                        ->label('Date')
                        ->dateTime(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket.ticket_number')
                    ->sortable()
                    ->searchable()
                    ->label('Ticket Number'),
                    
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->label('User'),
                
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Open' => 'danger',
                        'In Progress' => 'warning',
                        'Closed' => 'success',
                    })
                    ->label('Status'),

                Tables\Columns\TextColumn::make('comments')
                    ->sortable()
                    ->searchable()
                    ->label('Comments'),

                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo')
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
                // Add filters if necessary
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relations here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeedback::route('/'),
            'create' => Pages\CreateFeedback::route('/create'),
            'view' => Pages\ViewFeedback::route('/{record}'),
            'edit' => Pages\EditFeedback::route('/{record}/edit'),
        ];
    }
}
