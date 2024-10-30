<?php

namespace App\Filament\Wh\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\TrayStock;
use App\Models\MasterRack;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Wh\Resources\TrayStockResource\Pages;
use Filament\Infolists\Components\Card as InfolistCard;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Wh\Resources\TrayStockResource\RelationManagers\TrayInRelationManager;
use App\Filament\Wh\Resources\TrayStockResource\RelationManagers\TrayOutRelationManager;

class TrayStockResource extends Resource
{
    protected static ?string $model = TrayStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Data Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('plant_buffer')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('material')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('plant')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('material_description')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('qty')
                            ->required()
                            ->numeric(),
                        Select::make('master_racks_id')
                            ->label('Locator')
                            ->options(MasterRack::all()->pluck('locator_number', 'id'))
                            ->searchable(),
                    ])->columns(2),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('plant_buffer'),
                    TextEntry::make('material'),
                    TextEntry::make('plant'),
                    TextEntry::make('material_description'),
                    TextEntry::make('masterracks.locator_number')
                        ->label('Locator'),
                    TextEntry::make('qty'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('plant_buffer')->searchable(),
                Tables\Columns\TextColumn::make('material')->searchable(),
                Tables\Columns\TextColumn::make('plant')->searchable(),
                Tables\Columns\TextColumn::make('material_description')->searchable(),
                Tables\Columns\TextColumn::make('qty_in')
                    ->label('Total Tray In Quantity')
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty_out')
                    ->label('Total Tray Out Quantity')
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->label('Current Total Quantity')
                    ->numeric()
                    ->badge(fn ($state) => $state < 0 ? 'danger' : 'success')
                    ->color(fn ($state) => $state < 0 ? 'danger' : 'success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('masterracks.locator_number')
                    ->label('Locator Number')
                    ->searchable(),                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('PIC')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('History Transaction')
                    ->button(),
                Tables\Actions\EditAction::make()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->before(function ($record, array $data) {
                        if (empty($data['reason_to_delete'])) {
                            throw new \Exception('Reason to delete is required.');
                        }
                        $record->reason_to_delete = $data['reason_to_delete'];
                        $record->save();
                    })
                    ->form([
                        Forms\Components\TextInput::make('reason_to_delete')
                            ->label('Reason to Delete')
                            ->placeholder('Masukkan alasan untuk menghapus data')
                            ->required(),
                    ]),
                Tables\Actions\ForceDeleteAction::make()
                        ->hidden(fn () => !auth()->user()->isSuperAdmin()),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                    ExportBulkAction::make()
                        ->label('Export Excel')
                        ->hidden(fn () => !auth()->user()->isSuperAdmin() && !auth()->user()->isSuperAdminWh() && !auth()->user()->isAdminWh()),
                    Tables\Actions\DeleteBulkAction::make()
                        ->hidden(fn () => !auth()->user()->isSuperAdmin() && !auth()->user()->isSuperAdminWh()),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->hidden(fn () => !auth()->user()->isSuperAdmin()),
                    Tables\Actions\RestoreBulkAction::make()
                        ->hidden(fn () => !auth()->user()->isSuperAdmin() && !auth()->user()->isSuperAdminWh()),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TrayInRelationManager::class,
            TrayOutRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrayStocks::route('/'),
            'view' => Pages\ViewTrayStock::route('/{record}'),
            'edit' => Pages\EditTrayStock::route('/{record}/edit'),
        ];
    }
}
