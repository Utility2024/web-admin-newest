<?php

namespace App\Filament\Form\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ComelateEmployee;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Card as InfolistCard;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Form\Resources\ComelateEmployeeResource\Pages;
use App\Filament\Form\Resources\ComelateEmployeeResource\RelationManagers;
use Filament\Resources\Components\Tab;

class ComelateEmployeeResource extends Resource
{
    protected static ?string $model = ComelateEmployee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('nik')
                            ->label('NIK')
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->options(function () {
                                return Employee::query()
                                    ->select('ID', 'user_login', 'Display_Name')
                                    ->get()
                                    ->mapWithKeys(function ($employee) {
                                        return [
                                            $employee->user_login => $employee->user_login . ' - ' . $employee->Display_Name
                                        ];
                                    });
                            })
                            ->afterStateUpdated(function (callable $set, $state) {
                                // Temukan employee berdasarkan user_login
                                $employee = Employee::query()->where('user_login', $state)->first();
                                if ($employee) {
                                    $set('name', $employee->Display_Name);
                                    $set('department', $employee->Departement);
                                } else {
                                    $set('name', null);
                                    $set('department', null);
                                }
                            }),
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\TextInput::make('department')
                            ->label('Department')
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                        ToggleButtons::make('shift')
                            ->required()
                            ->options([
                                'Non Shift' => 'Non Shift',
                                'Shift 1' => 'Shift 1',
                                'Shift 2' => 'Shift 2',
                                'Shift 3' => 'Shift 3',
                            ])
                            ->colors([
                                'draft' => 'info',
                                'scheduled' => 'warning',
                                'published' => 'success',
                            ])
                            ->inline(),
                        Forms\Components\Select::make('alasan_terlambat')
                            ->options([
                                'Macet Lalulintas' => 'Macet Lalulintas',
                                'Masalah Kendaraan' => 'Masalah Kendaraan',
                                'Telat Berangkat' => 'Telat Berangkat',
                                'Keperluan Pribadi' => 'Keperluan Pribadi',
                                'Keperluan Keluarga' => 'Keperluan Keluarga',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('nama_security')
                            ->required()
                            ->maxLength(255),
                        DatePicker::make('tanggal'),
                        TimePicker::make('jam')
                    ])->columns(2)
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('nik'),
                    TextEntry::make('name'),
                    TextEntry::make('department'),
                    TextEntry::make('shift'),
                    TextEntry::make('alasan_terlambat'),
                    TextEntry::make('nama_security'),
                    TextEntry::make('tanggal'),
                    TextEntry::make('jam'),
                    // TextEntry::make('created_at'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label("No.")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nik')
                    ->sortable()
                    ->label('NIK'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shift')
                    ->searchable(),
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
                    ->label("Created At")
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Filter::make('tanggal')
                    ->form([
                        Select::make('created_year')
                            ->options([
                                '2024' => '2024',
                                '2023' => '2023',
                                // Tambahkan tahun sesuai kebutuhan Anda
                            ])
                            ->placeholder('Pilih Tahun'),
                        Select::make('created_month')
                            ->options([
                                '01' => 'Januari',
                                '02' => 'Februari',
                                '03' => 'Maret',
                                '04' => 'April',
                                '05' => 'Mei',
                                '06' => 'Juni',
                                '07' => 'Juli',
                                '08' => 'Agustus',
                                '09' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember',
                            ])
                            ->placeholder('Pilih Bulan'),
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '<=', $date),
                            )
                            ->when(
                                $data['created_year'],
                                fn (Builder $query, $year): Builder => $query->whereYear('tanggal', $year),
                            )
                            ->when(
                                $data['created_month'],
                                fn (Builder $query, $month): Builder => $query->whereMonth('tanggal', $month),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
            
                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('Date From ' . Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }
            
                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Date until ' . Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }
            
                        if ($data['created_year'] ?? null) {
                            $indicators[] = Indicator::make('Year ' . $data['created_year'])
                                ->removeField('created_year');
                        }
            
                        if ($data['created_month'] ?? null) {
                            $indicators[] = Indicator::make('Month ' . Carbon::create(null, $data['created_month'])->format('F'))
                                ->removeField('created_month');
                        }
            
                        return $indicators;
                    })
            ])->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button()
                    ->hidden(fn ($record) => Carbon::now()->diffInMinutes($record->created_at) >= 1440), // Hide if more than 5 minutes
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                    ExportBulkAction::make()
                        ->label('Export Excel'),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListComelateEmployees::route('/'),
            'create' => Pages\CreateComelateEmployee::route('/create'),
            'view' => Pages\ViewComelateEmployee::route('/{record}'),
            'edit' => Pages\EditComelateEmployee::route('/{record}/edit'),
        ];
    }

    public static function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Macet Lalulintas' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->where('alasan_terlambat', 'Macet Lalulintas');
                }),
            'Masalah Kendaraan' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->where('alasan_terlambat', 'Masalah Kendaraan');
                }),
            'Telat Berangkat' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->where('alasan_terlambat', 'Telat Berangkat');
                }),
            'Keperluan Pribadi' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->where('alasan_terlambat', 'Keperluan Pribadi');
                }),
            'Keperluan Keluarga' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->where('alasan_terlambat', 'Keperluan Keluarga');
                }),

        ];
    }
}
