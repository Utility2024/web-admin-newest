<?php

namespace App\Filament\Wh\Resources\TrayStockResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrayOutRelationManager extends RelationManager
{
    protected static string $relationship = 'trayOuts';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tray_stock_id')
            ->columns([
                Tables\Columns\TextColumn::make('traystock.plant_buffer')
                    ->label('Plant Buffer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('masterracks.locator_number')
                    ->label('Locator Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('plant')
                    ->label('Plant')
                    ->default(fn ($record) => $record->traystock->plant ?? null),
                Tables\Columns\TextColumn::make('material_description')
                    ->label('Material Description')
                    ->default(fn ($record) => $record->traystock->material_description ?? null),
                Tables\Columns\TextColumn::make('qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('PIC')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
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
