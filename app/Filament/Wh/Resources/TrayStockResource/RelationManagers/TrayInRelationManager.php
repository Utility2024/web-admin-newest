<?php

namespace App\Filament\Wh\Resources\TrayStockResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrayInRelationManager extends RelationManager
{
    protected static string $relationship = 'trayIns';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tray_stock_id')
            ->columns([
                Tables\Columns\TextColumn::make('traystock.plant_buffer') // Assuming 'masterRack' is the relationship name
                    ->label('Plant Buffer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('masterracks.locator_number') // Assuming 'masterRack' is the relationship name
                    ->label('Locator Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('masterracks.locator_number')
                    ->label('Locator Number')
                    ->default(fn ($record) => $record->masterracks->locator_number ?? null),
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
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
