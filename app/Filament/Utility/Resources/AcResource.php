<?php

namespace App\Filament\Utility\Resources;

use App\Models\Ac;
use Filament\Forms;
use Filament\Tables;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Utility\Resources\AcResource\Pages;
use Filament\Infolists\Components\Card as InfolistCard;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;

class AcResource extends Resource
{
    protected static ?string $model = Ac::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $navigationLabel = 'Air Conditioning';

    public static function form(Forms\Form $form): Forms\Form
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
                        Forms\Components\TextInput::make('type')
                            ->label('Type'),
                        Forms\Components\TextInput::make('pk_capacity')
                            ->label('PK Capacity'),
                        Forms\Components\TextInput::make('status')
                            ->label('Status'),
                        Forms\Components\TextInput::make('btu')
                            ->label('BTU'),
                        Forms\Components\TextInput::make('type_freon')
                            ->label('Type of Freon'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('area')
                        ->label('Area'),
                    TextEntry::make('equipment_name')
                        ->label('Equipment Name'),
                    TextEntry::make('equipment_number')
                        ->label('Equipment Number'),
                    TextEntry::make('location')
                        ->label('Location'),
                ])->columns(2)  ,
                InfolistCard::make([
                    TextEntry::make('type')
                        ->label('Type'),
                    TextEntry::make('pk_capacity')
                        ->label('PK Capacity'),
                    TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger',
                        })
                        ->label('Status'),
                    TextEntry::make('btu')
                        ->label('BTU'),
                    TextEntry::make('type_freon')
                        ->label('Type of Freon'),
                ])->columns(2)
            ]);
    }


    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('type')
                    ->label('Type'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    })
                    ->label('Status'),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Created By')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->datetime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->groups([
                Group::make('area'),
                Group::make('type')
            ])
            ->filters([
                // Add any filters if needed
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->label('Add New AC')
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
            // Define any relations if necessary
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcs::route('/'),
            // 'create' => Pages\CreateAc::route('/create'),
            'view' => Pages\ViewAc::route('/{record}'),
            // 'edit' => Pages\EditAc::route('/{record}/edit'),
        ];
    }
}
