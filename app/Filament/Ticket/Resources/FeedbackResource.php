<?php

namespace App\Filament\Ticket\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Feedback;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Card as InfolistCard;
use App\Filament\Ticket\Resources\FeedbackResource\Pages;
use Illuminate\Support\Facades\Auth;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Ticketing';
    protected static bool $shouldRegisterNavigation = false;

    public static function canViewNavigation(): bool
    {
        return Gate::allows('view-feedback-navigation');
    }

    public static function form(Form $form): Form
    {
        $ticketId = session('ticket_id');
        $user = Auth::user();

        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('ticket_id')
                            ->options(
                                \App\Models\Ticket::where('id', session('ticket_id'))->pluck('ticket_number', 'id')->toArray()
                            ) // Mengambil hanya ticket_id dari session
                            ->required()
                            ->searchable()
                            ->label('Ticket')
                            ->reactive()
                            ->default(session('ticket_id')) // Mengambil ticket_id dari session
                            ->extraAttributes(['style' => 'pointer-events: none;']) // Menonaktifkan interaksi
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

                        Forms\Components\ToggleButtons::make('status')
                            ->options([
                                'Open' => 'Open',
                                'Pending' => 'Pending',
                                'In Progress' => 'In Progress',
                                'Closed' => 'Closed',
                            ])
                            ->colors([
                                'Open' => 'info',
                                'Pending' => 'danger',
                                'In Progress' => 'warning',
                                'Closed' => 'success',
                            ])
                            ->inline()
                            ->default('Open')
                            ->required()
                            ->label('Status')
                            ->reactive(),

                        Forms\Components\Textarea::make('comments')
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('photo')
                            ->disk('public')
                            ->label('Photo')
                            ->image(),
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('ticket_id')->label('Ticket Number'),
                    TextEntry::make('user.name')->label('User'),
                    TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'Open' => 'danger',
                            'Pending' => 'info',
                            'In Progress' => 'warning',
                            'Closed' => 'success',
                        })
                        ->label('Status'),
                    TextEntry::make('comments')->label('Comments'),
                ])->columns(2),
                InfolistCard::make([
                    ImageEntry::make('photo')->label('Photo'),
                    TextEntry::make('created_at')->label('Date')->dateTime(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        $ticketId = session('ticket_id'); // Ambil ticket_id dari session

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket_id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->label('User'),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Open' => 'danger',
                        'Pending' => 'info',
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
                // Filter untuk hanya menampilkan data berdasarkan ticket_id
                Tables\Filters\SelectFilter::make('ticket_id')
                    ->options(function () {
                        // Ambil semua ticket_id yang tersedia
                        return \App\Models\Ticket::pluck('ticket_number', 'id')->toArray();
                    })
                    ->default($ticketId), // Set default filter sesuai ticket_id dari session
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
