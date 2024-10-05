<?php

namespace App\Filament\Wh\Resources\MasterRackResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrayStockRelationManager extends RelationManager
{
    protected static string $relationship = 'trayStocks';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('plant_buffer')
            ->columns([
                Tables\Columns\TextColumn::make('plant_buffer')->searchable(),
                Tables\Columns\TextColumn::make('material')->searchable(),
                Tables\Columns\TextColumn::make('plant')->searchable(),
                Tables\Columns\TextColumn::make('material_description')->searchable(),
                Tables\Columns\TextColumn::make('trayIns.qty')
                    ->label('Total Tray In Quantity')
                    ->formatStateUsing(fn ($record) => $record->trayIns()->sum('qty'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('trayOuts.qty')
                    ->label('Total Tray Out Quantity')
                    ->formatStateUsing(fn ($record) => $record->trayOuts()->sum('qty'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->label('Current Total Quantity')
                    ->numeric()
                    ->sortable(),               
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
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
