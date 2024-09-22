<?php

namespace App\Filament\Hr\Resources\EmployeeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;

class ComelateEmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'comelateEmployees';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nik')
            ->columns([
                // Tables\Columns\TextColumn::make('nik'),
                Tables\Columns\TextColumn::make('alasan_terlambat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_security')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jam')
                    ->label('Jam')
                    ->searchable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Date Time")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('alasan_terlambat')
                    ->options([
                        'Macet Lalulintas' => 'Macet Lalulintas',
                        'Masalah Kendaraan' => 'Masalah Kendaraan',
                        'Telat Berangkat' => 'Telat Berangkat',
                        'Keperluan Pribadi' => 'Keperluan Pribadi',
                        'Keperluan Keluarga' => 'Keperluan Keluarga',
                    ])
                    ->attribute('alasan_terlambat')
                    ->preload()
            ])->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filter')
            )
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
