<?php

namespace App\Filament\Wh\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\TrayOut;
use Filament\Forms\Form;
use App\Models\TrayStock;
use App\Models\MasterRack;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Awcodes\Shout\Components\Shout;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Wh\Resources\TrayOutResource\Pages;
use Filament\Infolists\Components\Card as InfolistCard;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class TrayOutResource extends Resource
{
    protected static ?string $model = TrayOut::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-start-on-rectangle';

    protected static ?string $navigationLabel = 'Tray Out';

    protected static ?string $navigationGroup = 'Transactions';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('tray_stock_id')
                            ->label('Plant Buffer / Item PKG')
                            ->options(TrayStock::all()->mapWithKeys(function ($trayStock) {
                                return [$trayStock->id => $trayStock->material . ' (' . $trayStock->material_description . ') '];
                            }))
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                if ($state) {
                                    $trayStock = TrayStock::find($state);
                                    // Set placeholders with the fetched data
                                    $set('material', $trayStock->material);
                                    $set('plant', $trayStock->plant);
                                    $set('material_description', $trayStock->material_description);
                                    $set('master_racks_id', $trayStock->master_racks_id); // For display only
                                } else {
                                    $set('material', null);
                                    $set('plant', null);
                                    $set('material_description', null);
                                    $set('master_racks_id', null); // For display only
                                }
                            }),
                        Forms\Components\Placeholder::make('material')
                            ->label('Material')
                            ->content(fn (callable $get) => $get('material'))
                            ->visible(fn (callable $get) => $get('tray_stock_id') !== null),
                        Forms\Components\Placeholder::make('plant')
                            ->label('Plant')
                            ->content(fn (callable $get) => $get('plant'))
                            ->visible(fn (callable $get) => $get('tray_stock_id') !== null),
                        Forms\Components\Placeholder::make('material_description')
                            ->label('Material Description')
                            ->content(fn (callable $get) => $get('material_description'))
                            ->visible(fn (callable $get) => $get('tray_stock_id') !== null),
                            Shout::make('so-important')
                            ->content(fn (callable $get) => 'Before entering Products, make sure it is the same as the rack number you choose') // Adjust as necessary
                            ->color(Color::Yellow)
                            ->visible(fn (callable $get) => $get('tray_stock_id') !== null), // Only visible if tray_stock_id is selected
                        Forms\Components\Select::make('master_racks_id')
                            ->label('These items are on the following Locator / Racks')
                            ->options(MasterRack::all()->pluck('locator_number', 'id'))
                            ->required()
                            ->searchable()
                            ->visible(fn (callable $get) => $get('tray_stock_id') !== null),
                        ]),
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('qty')
                            ->required()
                            ->numeric(),
                    ])
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('traystock.plant_buffer')
                        ->label('Plant Buffer')
                        ->default(fn ($record) => $record->traystock->plant_buffer ?? null),
                    TextEntry::make('masterracks.locator_number')
                        ->label('Locator Number')
                        ->default(fn ($record) => $record->masterracks->locator_number ?? null),
                    TextEntry::make('plant')
                        ->label('Plant')
                        ->default(fn ($record) => $record->traystock->plant ?? null),
                    TextEntry::make('material_description')
                        ->label('Material Description')
                        ->default(fn ($record) => $record->traystock->material_description ?? null),
                    TextEntry::make('qty')
                        ->label('Quantity')
                        ->default(fn ($record) => $record->qty ?? null),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('traystock.plant_buffer')
                    ->label('Plant Buffer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('traystock.material')
                    ->label('Material')
                    ->default(fn ($record) => $record->traystock->material ?? null),
                Tables\Columns\TextColumn::make('masterracks.locator_number')
                    ->label('Locator Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('plant')
                    ->label('Plant')
                    ->default(fn ($record) => $record->traystock->plant ?? null),
                Tables\Columns\TextColumn::make('material_description')
                    ->label('Material Description')
                    ->default(fn ($record) => $record->traystock->material_description ?? null),
                Tables\Columns\TextColumn::make('qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('PIC')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->visible(fn () => Auth::user()->isSuperAdmin() || Auth::user()->isSuperAdminWh()),
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
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            )
                            ->when(
                                $data['created_year'],
                                fn (Builder $query, $year): Builder => $query->whereYear('created_at', $year),
                            )
                            ->when(
                                $data['created_month'],
                                fn (Builder $query, $month): Builder => $query->whereMonth('created_at', $month),
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
            ->filtersFormWidth(MaxWidth::TwoExtraLarge)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button()
                    ->hidden(fn ($record) => Carbon::now()->diffInMinutes($record->created_at) >= 1440), // Hide if more than 5 minutes 
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->before(function ($record, array $data) {
                        if (empty($data['reason_to_delete'])) {
                            throw new \Exception('Reason to delete is required.');
                        }

                        $record->reason_to_delete = $data['reason_to_delete'];
                        $record->save();
                    })
                    ->form([
                        Forms\Components\TextInput::make('reason_to_delete')
                            ->label('Reason to Delete')
                            ->placeholder('Masukkan alasan untuk menghapus data')
                            ->required(),
                    ]),
                Tables\Actions\ForceDeleteAction::make()
                        ->hidden(function () {
                            return !auth()->user()->isSuperAdmin(); // Sembunyikan jika pengguna bukan SUPERADMIN
                        }),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->label('Export Excel')
                    ->hidden(function () {
                        return !auth()->user()->isSuperAdmin() && !auth()->user()->isSuperAdminWh() && !auth()->user()->isAdminWh(); // Sembunyikan jika pengguna bukan SUPERADMIN
                    }),
                Tables\Actions\DeleteBulkAction::make()
                    ->hidden(function () {
                        return !auth()->user()->isSuperAdmin() && !auth()->user()->isSuperAdminWh(); // Sembunyikan jika pengguna bukan SUPERADMIN
                    }),
                Tables\Actions\ForceDeleteBulkAction::make()
                    ->hidden(function () {
                        return !auth()->user()->isSuperAdmin(); // Sembunyikan jika pengguna bukan SUPERADMIN
                    }),
                Tables\Actions\RestoreBulkAction::make()
                    ->hidden(function () {
                        return !auth()->user()->isSuperAdmin() && !auth()->user()->isSuperAdminWh(); // Sembunyikan jika pengguna bukan SUPERADMIN
                    }),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrayOuts::route('/'),
            'create' => Pages\CreateTrayOut::route('/create'),
            'view' => Pages\ViewTrayOut::route('/{record}'),
            'edit' => Pages\EditTrayOut::route('/{record}/edit'),
        ];
    }
}
