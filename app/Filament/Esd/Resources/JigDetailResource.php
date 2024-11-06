<?php

namespace App\Filament\Esd\Resources;

use App\Models\Jig;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\JigDetail;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Esd\Resources\JigDetailResource\Pages;
use App\Filament\Esd\Resources\JigDetailResource\RelationManagers;
use Filament\Forms\Components\DatePicker;

class JigDetailResource extends Resource
{
    protected static ?string $model = JigDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('jigs_id')
                            ->label('Register No')
                            ->required()
                            ->relationship('Jig', 'register_no')
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $Jig = Jig::find($state);
                                if ($Jig) {
                                    $set('location', $Jig->location);
                                } else {
                                    $set('location', null);
                                }
                            }),
                        Forms\Components\TextInput::make('location')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('j1')
                            ->required()
                            ->numeric()
                            ->label('J1')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('judgement_j1', $state > 1.00 ? 'NG' : 'OK');
                            }),
                        Forms\Components\ToggleButtons::make('judgement_j1')
                            ->label('Judgement J1')
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
                        Forms\Components\TextInput::make('j2')
                            ->required()
                            ->numeric()
                            ->label('J2')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('judgement_j2', $state > 100 ? 'NG' : 'OK');
                            }),
                        Forms\Components\ToggleButtons::make('judgement_j2')
                            ->label('Judgement J2')
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
                Tables\Columns\TextColumn::make('jig.register_no')
                    ->label('Register No')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('j1')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('judgement_j1')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    })
                    ->label('Judgement J1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('j2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('judgement_j2')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    })
                    ->label('Judgement J2')
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
            'index' => Pages\ListJigDetails::route('/'),
            'create' => Pages\CreateJigDetail::route('/create'),
            'view' => Pages\ViewJigDetail::route('/{record}'),
            'edit' => Pages\EditJigDetail::route('/{record}/edit'),
        ];
    }
}
