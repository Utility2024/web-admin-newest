<?php

namespace App\Filament\Production\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\DetailWip;
use App\Models\MasterWip;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Card as InfolistCard;
use App\Filament\Production\Resources\MasterWipResource\Pages;
use App\Filament\Production\Resources\MasterWipResource\RelationManagers;
use App\Filament\Production\Resources\MasterWipResource\RelationManagers\DetailWipsRelationManager;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class MasterWipResource extends Resource
{
    protected static ?string $model = MasterWip::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Master Transfer WIP';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('model')
                            ->label('Model')
                            ->required(),
                        Forms\Components\TextInput::make('dj')
                            ->label('DJ')
                            ->required(),
                        Forms\Components\TextInput::make('lot_qty')
                            ->label('Lot Quantity')
                            ->numeric()
                            ->required(),
                    ])
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('model'),
                    TextEntry::make('dj')->label('DJ'),
                    TextEntry::make('lot_qty')->label('Lot Qty'),
                    TextEntry::make('status')
                        ->label('Status')
                        ->default(fn($record) => $record->getLatestStatus())
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'Open' => 'danger',
                            'In Progress' => 'warning',
                            'Finished' => 'success',
                        }), // Ensure status is displayed
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('model')->label('Model')
                    ->wrap(),
                Tables\Columns\TextColumn::make('dj')->label('DJ')
                    ->wrap(),
                Tables\Columns\TextColumn::make('lot_qty')->label('Lot Quantity')
                    ->wrap(),
                Tables\Columns\TextColumn::make('status')
                    ->wrap()
                    ->label('Status')
                    ->default(fn($record) => $record->getLatestStatus())
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Open' => 'danger',
                        'In Progress' => 'warning',
                        'Finished' => 'success',
                    }),
                Tables\Columns\TextColumn::make('approval')
                    ->wrap()
                    ->label('Approval SPV')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Waiting Approval' => 'danger',
                        'Approved' => 'success'
                    }),
                Tables\Columns\TextColumn::make('acceptance_status')
                    ->wrap()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Waiting Accept By SOP/Leader' => 'danger',
                        'Accepted' => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Date')->dateTime()->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('creator.name')->label('SPV Created')->sortable()->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('updater.name')->label('Received By')->sortable()->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // Filter by status, etc.
            ])
            ->actions([
                Tables\Actions\Action::make('updateApproval')
                    ->label('Approval')
                    ->button()
                    ->action(function ($record) {
                        $newApproval = 'Approved'; // The new status can be changed as needed

                        // Update both acceptance_status and updated_by fields
                        $record->update([
                            'approval' => $newApproval,
                        ]);

                        Notification::make()
                            ->title('Approved')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->hidden(fn($record) => !auth()->user()->isAdminWip() || $record->approval === 'Approved')// Hide if not admin or already approved
                        ->label('Approved')
                        ->button()
                        ->action(function ($record) {
                            // Check if the current acceptance status is already 'Accepted'
                            if ($record->approval === 'Approved') {
                                Notification::make()
                                    ->title('No Action Needed')
                                    ->body('The acceptance status is already set to "Approved".')
                                    ->danger() // You can use danger color for emphasis
                                    ->send();

                                return; // Exit the action early if the status is already 'Accepted'
                            }

                            $newApproval = 'Approved'; // The new status can be changed as needed

                            // Update both acceptance_status and updated_by fields
                            $record->update([
                                'approval' => $newApproval// Set updated_by to the authenticated user's ID
                            ]);

                            Notification::make()
                                ->title('Approved')
                                ->success()
                                ->send();
                        })
                        ->color('success')
                        ->requiresConfirmation(),
                Tables\Actions\Action::make('updateAcceptanceStatus')
                    ->label('Accept')
                    ->button()
                    ->action(function ($record) {
                        $newStatus = 'Accepted'; // The new status can be changed as needed

                        // Update both acceptance_status and updated_by fields
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
                    ->hidden(fn($record) => !auth()->user()->isUserWip() || $record->acceptance_status === 'Accepted') // Hide if not user or already accepted
                        ->label('Accept')
                        ->button()
                        ->action(function ($record) {
                            // Check if the current acceptance status is already 'Accepted'
                            if ($record->acceptance_status === 'Accepted') {
                                Notification::make()
                                    ->title('No Action Needed')
                                    ->body('The acceptance status is already set to "Accepted".')
                                    ->danger() // You can use danger color for emphasis
                                    ->send();

                                return; // Exit the action early if the status is already 'Accepted'
                            }

                            $newStatus = 'Accepted'; // The new status can be changed as needed

                            // Update both acceptance_status and updated_by fields
                            $record->update([
                                'acceptance_status' => $newStatus,
                                'updated_by' => Auth::id(), // Set updated_by to the authenticated user's ID
                            ]);

                            Notification::make()
                                ->title('Status Updated')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation(),
                Tables\Actions\ViewAction::make()
                    ->button(),
                Tables\Actions\EditAction::make()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->button(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DetailWipsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMasterWips::route('/'),
            'create' => Pages\CreateMasterWip::route('/create'),
            'view' => Pages\ViewMasterWip::route('/{record}'),
            'edit' => Pages\EditMasterWip::route('/{record}/edit'),
        ];
    }

    public function getLatestStatus()
    {
        // Fetch the latest DetailWip record's status
        return $this->detailWips()->latest()->value('status') ?: 'Not Available';
    }
}
