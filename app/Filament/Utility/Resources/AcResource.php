<?php

namespace App\Filament\Utility\Resources;

use App\Filament\Utility\Resources\AcResource\Pages;
use App\Filament\Utility\Resources\AcResource\RelationManagers;
use App\Models\Ac;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AcResource extends Resource
{
    protected static ?string $model = Ac::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $navigationLabel = 'Air Conditioning';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('area')
                            ->label('Area')
                            ->required(),
                        Forms\Components\TextInput::make('equipment_name')
                            ->label('Equipment Name')
                            ->required(),
                        Forms\Components\TextInput::make('equipment_number')
                            ->label('Equipment Number')
                            ->required(),
                        Forms\Components\TextInput::make('location')
                            ->label('Location')
                            ->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('area')
                    ->label('Area')
                    ->searchable(),
                Tables\Columns\TextColumn::make('equipment_name')
                    ->label('Equipment Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('equipment_number')
                    ->label('Equipment Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                // Add any filters if needed
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->button(),
                Tables\Actions\EditAction::make()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->button(),
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
            'index' => Pages\ListAcs::route('/'),
            'create' => Pages\CreateAc::route('/create'),
            'view' => Pages\ViewAc::route('/{record}'),
            'edit' => Pages\EditAc::route('/{record}/edit'),
        ];
    }
}
