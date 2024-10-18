<?php

namespace App\Filament\Esd\Resources\PackagingResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Packaging;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Forms\Components\ToggleButtons;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Awcodes\Shout\Components\Shout;
use Filament\Support\Colors\Color;

class PackagingDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'packagingDetails';

    public function form(Form $form): Form
    {
        $packagingId = session('packaging_id');

        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('packaging_id')
                            ->label('Packaging')
                            ->options(fn() => Packaging::pluck('register_no', 'id')->toArray())
                            ->rules('required')
                            ->default($packagingId)
                            ->extraAttributes(['style' => 'pointer-events: none']),

                        Select::make('status')
                            ->label('Status')
                            ->options(fn() => Packaging::pluck('status', 'id')->toArray())
                            ->default($packagingId)
                            ->extraAttributes(['style' => 'pointer-events: none']),

                        Select::make('item')
                            ->label('Item')
                            ->options(['Tray' => 'Tray', 'Black Box' => 'Black Box'])
                            ->rules('required'),

                        TextInput::make('f1')
                            ->label('F1')
                            ->rules('required|numeric|min:0|max:1000000000000000000')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Efficiently update b1_scientific and judgement
                                if ($state !== null && is_numeric($state)) {
                                    $scientific = sprintf('%.2E', $state);
                                    $set('f1_scientific', $scientific);
    
                                    // Update judgement
                                    $judgement = ($state < 10000 || $state > 100000000000) ? 'NG' : 'OK';
                                    $set('judgement', $judgement);
                                }
                            }),

                        TextInput::make('f1_scientific')
                            ->label('F1 Scientific')
                            ->rules('required')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\ToggleButtons::make('judgement_f1')
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

                        Shout::make('so-important')
                            ->content('Surface static field voltage ( < +/- 100 Volts )')
                            ->color(Color::Yellow),
                        Forms\Components\TextInput::make('f2')
                            ->required()
                            ->numeric()
                            ->label('F2')
                            ->reactive() // Make the field reactive
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Set the value of 'judgement' based on 'e1' value
                                $set('judgement_f2', $state > 100.00 ? 'NG' : 'OK');
                            }),
                        Forms\Components\ToggleButtons::make('judgement_f2')
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
                        Textarea::make('remarks')
                            ->label('Remarks'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('packaging_id')
            ->columns([
                    TextColumn::make('id')->sortable()->searchable(),
                    TextColumn::make('packaging.register_no')->label('Packaging')->sortable()->searchable(),
                    TextColumn::make('packaging.status')->label('Status')->sortable()->searchable(),
                    TextColumn::make('item')->sortable()->searchable(),
                    TextColumn::make('f1_scientific')->sortable()->searchable(),
                    TextColumn::make('judgement_f1')->sortable()->searchable()
                        ->label('Judgement F1')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        }),
                    TextColumn::make('f2')->sortable()->searchable(),
                    TextColumn::make('judgement_f2')->sortable()->searchable()
                        ->label('Judgement F2')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        }),
                    TextColumn::make('remarks')->sortable()->searchable(),
                    TextColumn::make('creator.name')
                        ->label('Created By')
                        ->sortable()
                        ->searchable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('updater.name')
                        ->label('Updated By')
                        ->sortable()
                        ->searchable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('created_at')
                        ->label('Date')
                        ->date()
                        ->sortable(),
                    TextColumn::make('next_date')
                        ->date()
                        ->sortable(),
                    TextColumn::make('updated_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(), // Menambahkan tombol Add Action di header
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
