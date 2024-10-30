<?php

namespace App\Filament\Ticket\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Ticket;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CategoryTicket;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Ticket\Resources\FeedbackResource;
use App\Filament\Ticket\Resources\TicketResource\Pages;
use Filament\Infolists\Components\Card as InfolistCard;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Parallax\FilamentComments\Infolists\Components\CommentsEntry;
use App\Filament\Ticket\Resources\TicketResource\RelationManagers;
use App\Filament\Ticket\Resources\TicketResource\RelationManagers\FeedbackRelationManager;
use App\Mail\TicketCreated;
use Illuminate\Support\Facades\Mail;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Ticketing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('ticket_number')
                            ->disabled()
                            ->default(fn() => Ticket::generateTicketNumber())
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->required(),
                        Forms\Components\TextInput::make('email_user')
                            ->email()
                            ->label('Email')
                            ->required(),
                    ])->columns(1),
                Card::make()
                    ->schema([        
                        Forms\Components\Textarea::make('description')->required(),
                    ]),
                Card::make()
                    ->schema([       
                        FileUpload::make('file')
                            ->label('Photo')
                            ->disk('public')
                            ->multiple(),
                    ])->columns(1), // Adjusted to close the Card component properly
                Card::make()
                    ->schema([
                        ToggleButtons::make('priority')
                            ->options([
                                'Low' => 'Low',
                                'Medium' => 'Medium',
                                'Urgent' => 'Urgent',
                                'Critical' => 'Critical',
                            ])
                            ->colors([
                                'Low' => 'info',
                                'Medium' => 'warning',
                                'Urgent' => 'danger',
                                'Critical' => 'primary',
                            ])
                            ->inline()
                            ->required(),
                        
                        Forms\Components\Select::make('assigned_role')
                            ->label('Assign To Section')
                            ->options(function () {
                                $allRoles = [
                                    'ADMINESD' => 'ESD (Electrostatic Discharge)',
                                    'ADMINUTILITY' => 'Utility & Building',
                                    'ADMINHR' => 'HR (Human Resource)',
                                    'ADMINGA' => 'GA (General Affair)',
                                ];
                                $user = Auth::user();
                                $filteredRoles = array_filter($allRoles, function ($role, $key) use ($user) {
                                    return !in_array($key, ['USER', 'SECURITY']) || !$user->isUser();
                                }, ARRAY_FILTER_USE_BOTH);
                                return $filteredRoles;
                            }),
                        
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required(),
                    ])->columns(3),
                ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('ticket_number'),
                    TextEntry::make('title'),
                    TextEntry::make('email_user')
                        ->label('Email'),
                    TextEntry::make('description'),
                    ImageEntry::make('file')
                        ->label('Photo')
                        ->disk('public')
                        ->extraAttributes([
                            'onclick' => 'openModal(this.src)',
                        ]),
                    TextEntry::make('status')->badge()->color(fn (string $state): string => match ($state) {
                        'Open' => 'danger',
                        'In Progress' => 'warning',
                        'Pending' => 'primary',
                        'Closed' => 'success',
                    }),
                    TextEntry::make('priority')->badge()->color(fn (string $state): string => match ($state) {
                        'Low' => 'gray',
                        'Medium' => 'warning',
                        'Urgent' => 'danger',
                        'Critical' => 'primary',
                    }),
                    TextEntry::make('category.name'),
                    TextEntry::make('assigned_role')
                        ->label('Assigned To Section')
                        ->formatStateUsing(function ($state) {
                            $roleMapping = [
                                'ADMINESD' => 'ESD (Electrostatic Discharge)',
                                'ADMINUTILITY' => 'Utility & Building',
                                'ADMINHR' => 'HR (Human Resource)',
                                'ADMINGA' => 'GA (General Affair)',
                            ];
                            return $roleMapping[$state] ?? $state;
                        }),
                    TextEntry::make('closed_at')->label('Closed Date'),
                ])->columns(3), // Adjusted to close the card properly
                InfolistCard::make([
                    TextEntry::make('approval')
                        ->label('Approval Manager')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'Approved' => 'success',
                            'Waiting Approval' => 'warning',
                            'Rejected' => 'danger',
                        }),
                    TextEntry::make('approval_at')->label('Approval Date'),
                    TextEntry::make('comment_manager')->label('Comment From Manager'),
                ])->columns(3),
                InfolistCard::make([
                    TextEntry::make('approval_user')
                        ->label('Approval User')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'Approved' => 'success',
                            'Waiting Approval' => 'warning',
                            'Rejected' => 'danger',
                        }),
                    TextEntry::make('approval_user_at')->label('Approval User Date'),
                    TextEntry::make('comment_user')->label('Comment From User'),
                ])->columns(3),
            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('ticket_number')
            ->columns([
                Tables\Columns\TextColumn::make('ticket_number')
                    ->sortable()
                    ->label('Ticket Number'),
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->wrap()
                    ->label('Title'),
                Tables\Columns\TextColumn::make('email_user')
                    ->wrap()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Open' => 'danger',
                        'In Progress' => 'warning',
                        'Pending' => 'danger',
                        'Closed' => 'success',
                    })
                    ->label('Status'),
                // ImageColumn::make('file')
                //     ->label('Photo')
                //     ->disk('public')
                //     ->circular()
                //     ->stacked()
                //     ->limit(3)
                //     ->limitedRemainingText()
                //     ->size(50),
                Tables\Columns\TextColumn::make('assigned_role')
                    ->label('Assigned To Section')
                    ->wrap()
                    ->formatStateUsing(function ($state) {
                        $roleMapping = [
                            'ADMINESD' => 'ESD (Electrostatic Discharge)',
                            'ADMINUTILITY' => 'Facility & Utility',
                            'ADMINHR' => 'HR (Human Resource)',
                            'ADMINGA' => 'GA (General Affair)',
                        ];
                        return $roleMapping[$state] ?? $state;
                    }),
                Tables\Columns\TextColumn::make('creator.name')
                    ->wrap()
                    ->label('Requester')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('approval')
                    ->wrap()
                    ->label('Approval Manager')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Approved' => 'success',
                        'Waiting Approval' => 'warning',
                        'Rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('approval_at')
                    ->label('Approval Date')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('approval_user')
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Approval User')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Approved' => 'success',
                        'Waiting Approval' => 'warning',
                        'Rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('approval_user_at')
                    ->label('Approval User Date')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Date'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Updated At')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('ticket_number', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Open' => 'Open',
                        'In Progress' => 'In Progress',
                        'Pending' => 'Pending',
                        'Closed' => 'Closed',
                    ]),
            ])
            ->actions([
                Action::make('approve_user')
                    ->button()
                    ->color('success')
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
                        Forms\Components\Textarea::make('comment_user')
                            ->label('Comments')
                            ->required(),
                    ])
                    ->icon('heroicon-o-check-badge')
                    ->action(function (array $data, Ticket $record): void {
                        $user = Auth::user();

                        // Set approval user and approval date
                        $record->approval_user = $data['approval_status'];
                        $record->approval_user_at = now();
                        $record->comment_user = $data['comment_user'] ?? $record->comments;
                        $record->save(); // Save data to the database

                        // Optional: Add notification if necessary
                        Notification::make()
                            ->title('Approval User Updated')
                            ->success()
                            ->send();
                    })
                    ->visible(fn () => Auth::user()->isUser()) // Only for role isUser
                    ->hidden(fn (Ticket $record) => $record->approval_user === 'Approved'), // Hide if already Approved

                Action::make('approve')
                    ->button()
                    ->label('Approval')
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
                        Forms\Components\Textarea::make('comment_manager')
                            ->label('Comments')
                            ->required(),
                    ])
                    ->action(function (array $data, Ticket $record): void {
                        $user = Auth::user();
                        if ($user->isManagerAdmin()) {
                            $record->approval = $data['approval_status']; // Save approval status
                            $record->approval_at = now();
                            $record->comment_manager = $data['comment_manager'] ?? $record->comments; // Save comment
                            $record->save();
                        }
                    })
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->hidden(fn ($record) => 
                        $record->approval === 'Approved' // Hide if already approved
                        || !Auth::user()->isManagerAdmin() // Hide if user is not manager admin
                    ),

                // View and Edit actions
                Tables\Actions\ViewAction::make()->button(),
                Tables\Actions\EditAction::make()->button()
                    ->hidden(fn ($record) => 
                        in_array($record->status, ['In Progress', 'Pending', 'Closed']) || 
                        $record->created_at < now()->subHours(24) // Check if ticket was created more than 24 hours ago
                    ),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->bulkActions([
                // You can uncomment and implement bulk actions if needed
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'view' => Pages\ViewTicket::route('/{record}'),
            // Uncomment if you have an edit page
            // 'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
    
}
