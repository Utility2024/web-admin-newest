<?php

namespace App\Filament\Esd\Resources\GarmentResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Awcodes\Shout\Components\Shout;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;

class GarmentDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'garmentDetails';

    public function form(Form $form): Form
    {
        $garmentId = session('nik');
        
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('nik')
                            ->label('NIK')
                            ->required()
                            ->relationship('garment', 'user_login')
                            ->searchable()
                            ->reactive()
                            ->default($garmentId)
                            ->extraAttributes(['style' => 'pointer-events: none;']),

                        Forms\Components\Select::make('name')
                            ->label('Name')
                            ->required()
                            ->relationship('garment', 'Display_Name')
                            ->searchable()
                            ->reactive()
                            ->default($garmentId)
                            ->extraAttributes(['style' => 'pointer-events: none;'])
                    ]),
                Card::make()
                    ->schema([
                        Shout::make('so-important')
                            ->content('Shirt point to point (1.00E+4 - 1.00E+11 Ohm)')
                            ->color(Color::Yellow),
                        Forms\Components\TextInput::make('d1')
                            //->label('D1 (Shirt point to point (1.00E+4 - 1.00E+11 Ohm))')
                            ->rules('required|numeric|min:0|max:1000000000000000000')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state !== null && is_numeric($state)) {
                                    $scientific = sprintf('%.2E', $state);
                                    $set('d1_scientific', $scientific);

                                    $judgement = ($state < 100000 || $state > 100000000000) ? 'NG' : 'OK';
                                    $set('judgement_d1', $judgement);
                                }
                            }),
                        Forms\Components\TextInput::make('d1_scientific')
                            // ->required()
                            ->maxLength(255)  
                            ->label('D1 Scientific')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\ToggleButtons::make('judgement_d1')
                            ->options([
                                'OK' => 'OK',
                                'NG' => 'NG'
                            ])
                            ->colors([
                                'OK' => 'success',
                                'NG' => 'danger'
                            ])
                            ->inline()
                            ->disabled()
                            ->dehydrated(),
                    ]),
                Card::make()
                    ->schema([
                        Shout::make('so-important')
                            ->content('Pants point to point (1.00E+4 - 1.00E+11 Ohm)')
                            ->color(Color::Yellow),
                        Forms\Components\TextInput::make('d2')
                            //->label('D2 (Pants point to point (1.00E+4 - 1.00E+11 Ohm))')
                            ->rules('required|numeric|min:0|max:1000000000000000000')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state !== null && is_numeric($state)) {
                                    $scientific = sprintf('%.2E', $state);
                                    $set('d2_scientific', $scientific);

                                    $judgement = ($state < 100000 || $state > 100000000000) ? 'NG' : 'OK';
                                    $set('judgement_d2', $judgement);
                                }
                            }),
                        Forms\Components\TextInput::make('d2_scientific')
                            // ->required()
                            ->maxLength(255)  
                            ->label('D2 Scientific')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\ToggleButtons::make('judgement_d2')
                            ->options([
                                'OK' => 'OK',
                                'NG' => 'NG'
                            ])
                            ->colors([
                                'OK' => 'success',
                                'NG' => 'danger'
                            ])
                            ->inline()
                            ->disabled()
                            ->dehydrated(),
                    ]),
                Card::make()
                    ->schema([
                        Shout::make('so-important')
                            ->content('Cap point to point (1.00E+4 - 1.00E+11 Ohm)')
                            ->color(Color::Yellow),
                        Forms\Components\TextInput::make('d3')
                            //->label('D3 (Cap point to point (1.00E+4 - 1.00E+11 Ohm))')
                            ->rules('required|numeric|min:0|max:1000000000000000000')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state !== null && is_numeric($state)) {
                                    $scientific = sprintf('%.2E', $state);
                                    $set('d3_scientific', $scientific);

                                    $judgement = ($state < 100000 || $state > 100000000000) ? 'NG' : 'OK';
                                    $set('judgement_d3', $judgement);
                                }
                            }),
                        Forms\Components\TextInput::make('d3_scientific')
                            // ->required()
                            ->maxLength(255)  
                            ->label('D3 Scientific')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\ToggleButtons::make('judgement_d3')
                            ->options([
                                'OK' => 'OK',
                                'NG' => 'NG'
                            ])
                            ->colors([
                                'OK' => 'success',
                                'NG' => 'danger'
                            ])
                            ->inline()
                            ->disabled()
                            ->dehydrated(),
                    ]),
                Card::make()
                    ->schema([
                        Shout::make('so-important')
                            ->content('Hijab point to point (1.00E+4 - 1.00E+11 Ohm)')
                            ->color(Color::Yellow),
                        Forms\Components\TextInput::make('d4')
                            //->label('D4 (Hijab point to point (1.00E+4 - 1.00E+11 Ohm))')
                            ->rules('required|numeric|min:0|max:1000000000000000000')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state !== null && is_numeric($state)) {
                                    $scientific = sprintf('%.2E', $state);
                                    $set('d4_scientific', $scientific);

                                    $judgement = ($state < 100000 || $state > 100000000000) ? 'NG' : 'OK';
                                    $set('judgement_d4', $judgement);
                                }
                            }),
                        Forms\Components\TextInput::make('d4_scientific')
                            // ->required()
                            ->maxLength(255)  
                            ->label('D4 Scientific')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\ToggleButtons::make('judgement_d4')
                            ->options([
                                'OK' => 'OK',
                                'NG' => 'NG'
                            ])
                            ->colors([
                                'OK' => 'success',
                                'NG' => 'danger'
                            ])
                            ->inline()
                            ->disabled()
                            ->dehydrated(),
                    ]),
                Card::make()
                    ->schema([
                        Forms\Components\Textarea::make('remarks')
                            ->nullable(),

                        ])
                ]);
                
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nik')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('d1_scientific')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('judgement_d1')
                    ->sortable()
                    ->label('Judgement D1')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('d2_scientific')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('judgement_d2')
                    ->sortable()
                    ->label('Judgement D2')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('d3_scientific')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('judgement_d3')
                    ->sortable()
                    ->label('Judgement D3')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('d4_scientific')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('judgement_d4')
                    ->sortable()
                    ->label('Judgement D4')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('remarks')
                    ->sortable()
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
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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
