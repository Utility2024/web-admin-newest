<?php

namespace App\Filament\Hr\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use App\Models\ComelateEmployee;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Hr\Resources\EmployeeResource\Pages;
use Filament\Infolists\Components\Card as InfolistCard;
use App\Filament\Hr\Resources\EmployeeResource\RelationManagers;
use App\Filament\Hr\Resources\EmployeeResource\RelationManagers\ComelateEmployeesRelationManager;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function infolist(Infolist $infolist): Infolist
    {
        $alasanCounts = [
            'Macet Lalulintas',
            'Masalah Kendaraan',
            'Telat Berangkat',
            'Keperluan Pribadi',
            'Keperluan Keluarga',
        ];

        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('Display_Name')->label('Name'),
                    TextEntry::make('user_login')->label('NIK'),
                    TextEntry::make('Departement'),
                    TextEntry::make('Last_Jobs'),
                    TextEntry::make('Last_Route'),
                ]),
                InfolistCard::make([
                    TextEntry::make('related_count_macet_lalulintas')
                        ->label('Macet Lalulintas')
                        ->badge()
                        ->color('primary')
                        ->getStateUsing(function ($record) {
                            return ComelateEmployee::where('nik', $record->user_login)
                                ->where('alasan_terlambat', 'Macet Lalulintas')
                                ->count();
                        }),
                    TextEntry::make('related_count_masalah_kendaraan')
                        ->label('Masalah Kendaraan')
                        ->badge()
                        ->color('primary')
                        ->getStateUsing(function ($record) {
                            return ComelateEmployee::where('nik', $record->user_login)
                                ->where('alasan_terlambat', 'Masalah Kendaraan')
                                ->count();
                        }),
                    TextEntry::make('related_count_telat_berangkat')
                        ->label('Telat Berangkat')
                        ->badge()
                        ->color('primary')
                        ->getStateUsing(function ($record) {
                            return ComelateEmployee::where('nik', $record->user_login)
                                ->where('alasan_terlambat', 'Telat Berangkat')
                                ->count();
                        }),
                    TextEntry::make('related_count_keperluan_pribadi')
                        ->label('Keperluan Pribadi')
                        ->badge()
                        ->color('primary')
                        ->getStateUsing(function ($record) {
                            return ComelateEmployee::where('nik', $record->user_login)
                                ->where('alasan_terlambat', 'Keperluan Pribadi')
                                ->count();
                        }),
                    TextEntry::make('related_count_keperluan_keluarga')
                        ->label('Keperluan Keluarga')
                        ->badge()
                        ->color('primary')
                        ->getStateUsing(function ($record) {
                            return ComelateEmployee::where('nik', $record->user_login)
                                ->where('alasan_terlambat', 'Keperluan Keluarga')
                                ->count();
                        }),
                ])->columns(5),
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

                Tables\Columns\TextColumn::make('Display_Name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user_login')
                    ->label('NIK')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('Departement')
                    ->label('Department')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('related_count')
                        ->label('Comelate Count')
                        ->badge()
                        ->color('primary')
                        ->getStateUsing(function ($record) {
                            return ComelateEmployee::where('nik', $record->user_login)->count();
                        })
            ])
            ->filters([
                SelectFilter::make('Departement')
                    ->options([
                        'ACCOUNTING' => 'ACCOUNTING',
                        'ADMIN' => 'ADMIN',
                        'COSTING INVENTORY' => 'COSTING INVENTORY',
                        'DCC' => 'DCC',
                        'EXIM' => 'EXIM',
                        'FG' => 'FG',
                        'INNOVATION' => 'INNOVATION',
                        'IT' => 'IT',
                        'MARKETING' => 'MARKETING',
                        'NPI' => 'NPI',
                        'OS' => 'OS',
                        'PPC' => 'PPC',
                        'PROD.1' => 'PROD.1',
                        'PROD.2' => 'PROD.2',
                        'PURCHASING' => 'PURCHASING',
                        'QA/QC' => 'QA/QC',
                        'TOOLING/IMPROVEMENT' => 'TOOLING/IMPROVEMENT',
                        'TRAINING' => 'TRAINING',
                        'VISITOR' => 'VISITOR',
                        'WAREHOUSE' => 'WAREHOUSE'
                    ])
                    ->attribute('Departement')
                    ->preload()
            ])->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filter')
            )
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public static function query(): Builder
    {
        return parent::query()
            ->selectRaw('(SELECT COUNT(*) FROM comelate_employees WHERE comelate_employees.nik = users.user_login) as related_count');
    }


    public static function getRelations(): array
    {
        return [
            ComelateEmployeesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            // 'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            // 'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
