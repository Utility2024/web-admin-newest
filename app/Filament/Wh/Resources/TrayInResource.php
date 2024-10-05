<?php

namespace App\Filament\Wh\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\TrayIn;
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
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Wh\Resources\TrayInResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Card as InfolistCard;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Wh\Resources\TrayInResource\RelationManagers;

class TrayInResource extends Resource
{
    protected static ?string $model = TrayIn::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-left-end-on-rectangle';

    protected static ?string $navigationLabel = 'Tray In';

    protected static ?string $navigationGroup = 'Transactions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('tray_stock_id')
                            ->label('Plant Buffer / Item PKG')
                            ->options(TrayStock::all()->pluck('plant_buffer', 'id'))
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
                            ->visible(fn (callable $get) => $get('tray_stock_id') !== null), // Only visible if tray_stock_id is selected
                        Forms\Components\Placeholder::make('plant')
                            ->label('Plant')
                            ->content(fn (callable $get) => $get('plant'))
                            ->visible(fn (callable $get) => $get('tray_stock_id') !== null), // Only visible if tray_stock_id is selected
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
                            ->visible(fn (callable $get) => $get('tray_stock_id') !== null), // For display only// Only visible if tray_stock_id is selected
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
                Tables\Columns\TextColumn::make('traystock.plant_buffer') // Assuming 'masterRack' is the relationship name
                    ->label('Plant Buffer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('masterracks.locator_number') // Assuming 'masterRack' is the relationship name
                    ->label('Locator Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('masterracks.locator_number')
                    ->label('Locator Number')
                    ->default(fn ($record) => $record->masterracks->locator_number ?? null),
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
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
            ])
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->filtersFormWidth(MaxWidth::TwoExtraLarge)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button(),
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
                        ->label('Export Excel'),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->hidden(function () {
                            return !auth()->user()->isSuperAdmin(); // Sembunyikan jika pengguna bukan SUPERADMIN
                        }),
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
            'index' => Pages\ListTrayIns::route('/'),
            'create' => Pages\CreateTrayIn::route('/create'),
            'view' => Pages\ViewTrayIn::route('/{record}'),
            'edit' => Pages\EditTrayIn::route('/{record}/edit'),
        ];
    }
}
