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
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Wh\Resources\MasterRackResource\Pages;
use Filament\Infolists\Components\Card as InfolistCard;
use App\Filament\Wh\Resources\MasterRackResource\RelationManagers;
use App\Filament\Wh\Resources\MasterRackResource\RelationManagers\TrayStockRelationManager;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class MasterRackResource extends Resource
{
    protected static ?string $model = MasterRack::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationLabel = 'Locator / Racks';

    protected static ?string $navigationGroup = 'Data Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('locator_number')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('capatity')
                            ->numeric()
                            ->required()
                            ->maxLength(255),
                    ]),
                Card::make()
                    ->schema([
                        ToggleButtons::make('status')
                            ->inline()
                            ->options([
                                'Filled' => 'Filled',
                                'Un-Filled' => 'Un-Filled',
                            ])
                            ->colors([
                                'Filled' => 'success',
                                'Un-Filled' => 'danger',
                            ]),
                        ToggleButtons::make('lamp')
                            ->inline()
                            ->options([
                                'On' => 'On',
                                'Off' => 'Off',
                            ])
                            ->colors([
                                'On' => 'success',
                                'Off' => 'danger',
                        ]),
                    ])
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('locator_number')
                        ->label('Plant Buffer'),
                    TextEntry::make('capatity')
                        ->label('Capatity'),
                    TextEntry::make('status')
                        ->label('Status'),
                    TextEntry::make('lamp')
                        ->label('Lamp')
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('locator_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('capatity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Filled' => 'success',
                        'Un-Filled' => 'danger',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('lamp')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'On' => 'success',
                        'Off' => 'danger',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('related_count')
                    ->label('Tray Count')
                    ->badge()
                    ->color('primary')
                    ->getStateUsing(function ($record) {
                        return TrayStock::where('master_racks_id', $record->id)->count();
                    }),
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
                Tables\Columns\TextColumn::make('updated_by')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View All Tray')
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
                        ->hidden(function () {
                            return !auth()->user()->isSuperAdmin(); // Sembunyikan jika pengguna bukan SUPERADMIN
                        }),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                    ExportBulkAction::make()
                        ->label('Export Excel')
                        ->hidden(function () {
                            return !auth()->user()->isSuperAdmin() && !auth()->user()->isSuperAdminWh() && !auth()->user()->isAdminWh(); // Sembunyikan jika pengguna bukan SUPERADMIN
                        }),
                    Tables\Actions\DeleteBulkAction::make()
                        ->hidden(function () {
                            return !auth()->user()->isSuperAdmin() && !auth()->user()->isSuperAdminWh(); // Sembunyikan jika pengguna bukan SUPERADMIN
                        }),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->hidden(function () {
                            return !auth()->user()->isSuperAdmin(); // Sembunyikan jika pengguna bukan SUPERADMIN
                        }),
                    Tables\Actions\RestoreBulkAction::make()
                        ->hidden(function () {
                            return !auth()->user()->isSuperAdmin() && !auth()->user()->isSuperAdminWh(); // Sembunyikan jika pengguna bukan SUPERADMIN
                        }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TrayStockRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMasterRacks::route('/'),
            'create' => Pages\CreateMasterRack::route('/create'),
            'view' => Pages\ViewMasterRack::route('/{record}'),
            'edit' => Pages\EditMasterRack::route('/{record}/edit'),
        ];
    }
}
