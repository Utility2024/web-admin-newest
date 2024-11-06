<?php

namespace App\Filament\Esd\Resources;

use App\Filament\Esd\Resources\MagazineDetailResource\Pages;
use App\Filament\Esd\Resources\MagazineDetailResource\RelationManagers;
use App\Models\MagazineDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Card;

class MagazineDetailResource extends Resource
{
    protected static ?string $model = MagazineDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('magazines_id')
                            ->label('Register No')
                            ->required()
                            ->relationship('Magazine', 'register_no')
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('m1')
                            ->label('M1')
                            ->rules('required|numeric|min:0|max:1000000000000000000')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Efficiently update b1_scientific and judgement
                                if ($state !== null && is_numeric($state)) {
                                    $scientific = sprintf('%.2E', $state);
                                    $set('m1_scientific', $scientific);
    
                                    // Update judgement
                                    $judgement = ($state < 10000 || $state > 100000000000) ? 'NG' : 'OK';
                                    $set('judgement_m1', $judgement);
                                }
                            }),

                        Forms\Components\TextInput::make('m1_scientific')
                            ->label('M1 Scientific')
                            ->rules('required')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\ToggleButtons::make('judgement_m1')
                            ->label('Judgement M1')
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
                        Forms\Components\TextInput::make('m2')
                            ->required()
                            ->numeric()
                            ->label('M2')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('judgement_m2', $state > 100 ? 'NG' : 'OK');
                            }),
                        Forms\Components\ToggleButtons::make('judgement_m2')
                            ->label('Judgement M2')
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
                            DatePicker::make('next_date')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('magazine.register_no')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('m1_scientific')
                    ->sortable(),
                Tables\Columns\TextColumn::make('judgement_m1')
                    ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        })
                    ->searchable(),
                Tables\Columns\TextColumn::make('m2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('judgement_m2')
                    ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        })
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
                    ->label('Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('next_date') 
                    ->date()   
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMagazineDetails::route('/'),
            'create' => Pages\CreateMagazineDetail::route('/create'),
            'view' => Pages\ViewMagazineDetail::route('/{record}'),
            'edit' => Pages\EditMagazineDetail::route('/{record}/edit'),
        ];
    }
}
