<?php

namespace App\Filament\MainMenu\Resources;

use App\Filament\MainMenu\Resources\InboxResource\Pages;
use App\Filament\MainMenu\Resources\InboxResource\RelationManagers;
use App\Models\Inbox;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InboxResource extends Resource
{
    protected static ?string $model = Inbox::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Inbox';

    public static function getNavigationLabel(): string
    {
        return 'Inbox';
    }

    public static function getNavigationBadge(): ?string
    {
        // Get the authenticated user
        $user = auth()->user();
    
        // Check if the user has the role of isManagerAdmin
        if ($user->isManagerAdmin()) {
            // If user is a ManagerAdmin, count all pending approvals
            return static::getModel()::where('approval', 'Pending')->count();
        }
    
        // Otherwise, count pending approvals for the authenticated user
        return static::getModel()::where('approval', 'Pending')
            ->where('user_id', $user->id) // Filter by user_id
            ->count();
    }       

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('transaction_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date & Time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Employee')
                    ->sortable(),
                Tables\Columns\TextColumn::make('message')
                    ->searchable(),
                Tables\Columns\TextColumn::make('approval')
                    ->label('Approval HOD Admin')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'Approved' => 'success',
                        'Rejected' => 'danger'
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->url(fn (Inbox $record) => $record->transaction_type === 'pengajuan_fasilitas'
                    ? "http://portal.siix-ems.co.id/form/pengajuan-fasilitas/{$record->transaction_id}"
                    : ($record->transaction_type === 'comelate_employee'
                        ? "http://portal.siix-ems.co.id/form/comelate-employees/{$record->transaction_id}"
                        : route('filament.resources.inboxes.view', $record))
                )
            
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInboxes::route('/'),
            'create' => Pages\CreateInbox::route('/create'),
            'view' => Pages\ViewInbox::route('/{record}'),
            'edit' => Pages\EditInbox::route('/{record}/edit'),
        ];
    }
}
