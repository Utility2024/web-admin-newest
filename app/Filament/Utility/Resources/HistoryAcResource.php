<?php

namespace App\Filament\Utility\Resources;

use App\Models\Ac;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\HistoryAc;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Utility\Resources\HistoryAcResource\Pages;
use App\Filament\Utility\Resources\HistoryAcResource\RelationManagers;
use Filament\Forms\Components\ToggleButtons;

class HistoryAcResource extends Resource
{
    protected static ?string $model = HistoryAc::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-left-end-on-rectangle';

    protected static ?string $navigationLabel = 'History AC';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('acs_id')
                            ->label('Equipment Number')
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->options(function () {
                                return Ac::query()
                                    ->select('id', 'equipment_number', 'equipment_name')
                                    ->get()
                                    ->mapWithKeys(function ($ac) {
                                        // Kembalikan 'id' sebagai nilai yang disimpan
                                        return [
                                            $ac->id => $ac->equipment_number . ' - ' . $ac->equipment_name,
                                        ];
                                    });
                            })
                            ->afterStateUpdated(function (callable $set, $state) {
                                $ac = Ac::query()->where('id', $state)->first();  // Cari berdasarkan ID
                                if ($ac) {
                                    $set('equipment_name', $ac->equipment_name);
                                    $set('area', $ac->area);
                                    $set('location', $ac->location);
                                    $set('type', $ac->type);
                                } else {
                                    $set('equipment_name', null);
                                    $set('area', null);
                                    $set('location', null);
                                    $set('type', null);
                                }
                            }),


                        Forms\Components\TextInput::make('equipment_name')
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('area')
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('location')
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('type')
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2),

                Card::make()
                    ->schema([
                        Forms\Components\ToggleButtons::make('status')
                            ->required()
                            ->inline()
                            ->options([
                                'OK' => 'OK',
                                'NG' => 'NG',
                            ]),

                        Forms\Components\TextArea::make('description')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('photo')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(3),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('acs.equipment_number') // Menampilkan equipment_number dari relasi ac
                    ->label('Equipment Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('equipment_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('area')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('photo')
                    ->searchable(),
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
            ->filters([
                //
            ])
            ->groups([
                Group::make('area'),
                Group::make('type')
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->label('Add New History AC')
            ])
            ->filters([
                // Add any filters if needed
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
            'index' => Pages\ListHistoryAcs::route('/'),
            // 'create' => Pages\CreateHistoryAc::route('/create'),
            'view' => Pages\ViewHistoryAc::route('/{record}'),
            // 'edit' => Pages\EditHistoryAc::route('/{record}/edit'),
        ];
    }
}
