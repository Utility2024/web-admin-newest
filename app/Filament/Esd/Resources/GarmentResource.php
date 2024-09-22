<?php

namespace App\Filament\Esd\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Garment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\GarmentDetail;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Esd\Resources\GarmentResource\Pages;
use Filament\Infolists\Components\Card as InfolistCard;
use App\Filament\Esd\Resources\GarmentResource\RelationManagers;
use App\Filament\Esd\Resources\GarmentResource\RelationManagers\GarmentDetailsRelationManager;

class GarmentResource extends Resource
{
    protected static ?string $model = Garment::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Data master';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('Display_Name')
                        ->label('Name'),
                    TextEntry::make('user_login')
                        ->label('NIK'),
                    TextEntry::make('Departement'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ID')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user_login')
                    ->label('NIK')
                    ->searchable()
                    ->sortable(),


                Tables\Columns\TextColumn::make('Display_Name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('Departement')
                    ->label('Department')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('Last_Group')
                    ->label('Last Group')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('related_count')
                    ->label('Measurement count')
                    ->badge()
                    ->color('primary')
                    ->getStateUsing(function ($record) {
                        return GarmentDetail::where('nik', $record->ID)->count();
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            GarmentDetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGarments::route('/'),
            'create' => Pages\CreateGarment::route('/create'),
            'view' => Pages\ViewGarment::route('/{record}'),
            'edit' => Pages\EditGarment::route('/{record}/edit'),
        ];
    }
}
