<?php

namespace App\Filament\Esd\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Packaging;
use Filament\Tables\Table;
use App\Models\PackagingDetail;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Awcodes\Shout\Components\Shout;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Forms\Components\ToggleButtons;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Card as InfolistCard;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Esd\Resources\PackagingDetailResource\Pages\EditPackagingDetail;
use App\Filament\Esd\Resources\PackagingDetailResource\Pages\ViewPackagingDetail;
use App\Filament\Esd\Resources\PackagingDetailResource\Pages\ListPackagingDetails;
use App\Filament\Esd\Resources\PackagingDetailResource\Pages\CreatePackagingDetail;
use App\Filament\Esd\Resources\PackagingDetailResource\Widgets\PackagingDetailStatsOverview;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf;

class PackagingDetailResource extends Resource
{
    protected static ?string $model = PackagingDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    protected static ?string $navigationGroup = 'Data measurement';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('packaging_id')
                            ->label('Register No')
                            ->required()
                            ->relationship('packaging', 'register_no')
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $Packaging = Packaging::find($state);
                                if ($Packaging) {
                                    $set('status', $Packaging->status);
                                } else {
                                    $set('status', null);
                                }
                            }),
                        TextInput::make('status')
                            ->label('Status')
                            // ->options(fn() => Packaging::pluck('status', 'id')->toArray())
                            ->required(),

                        Select::make('item')
                            ->label('Item')
                            ->options(['Tray' => 'Tray', 'Black Box' => 'Black Box'])
                            ->required(),
                        ]),
                Card::make()
                    ->schema([
                        Shout::make('so-important')
                         ->content('Dissipative packaging point to point ( 1.00E+4 - 1.00E+11 Ohm )')
                         ->color(Color::Yellow),
                        TextInput::make('f1')
                            ->label('F1')
                            ->rules('required|numeric|min:0|max:1000000000000000000')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Efficiently update b1_scientific and judgement
                                if ($state !== null && is_numeric($state)) {
                                    $scientific = sprintf('%.2E', $state);
                                    $set('f1_scientific', $scientific);
    
                                    // Update judgement
                                    $judgement = ($state < 10000 || $state > 100000000000) ? 'NG' : 'OK';
                                    $set('judgement_f1', $judgement);
                                }
                            }),

                        TextInput::make('f1_scientific')
                            ->label('F1 Scientific')
                            ->rules('required')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\ToggleButtons::make('judgement_f1')
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
                        ]),
                Card::make()
                    ->schema([
                    Shout::make('so-important')
                         ->content('Surface static field voltage ( < +/- 100 Volts )')
                         ->color(Color::Yellow),
                    Forms\Components\TextInput::make('f2')
                        ->required()
                        ->numeric()
                        ->label('F2')
                        ->reactive() // Make the field reactive
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Set the value of 'judgement' based on 'e1' value
                            $set('judgement_f2', $state > 100.00 ? 'NG' : 'OK');
                        }),
                    Forms\Components\ToggleButtons::make('judgement_f2')
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
                    ]),
                Card::make()
                    ->schema([
                        Textarea::make('remarks')
                            ->label('Remarks'),
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('packaging.register_no')->label('Register No'),
                    TextEntry::make('packaging.status')->label('Status'),
                    TextEntry::make('item'),
                ])->columns(2),
                InfolistCard::make([
                    TextEntry::make('f1_scientific')->label('F1 Scientific'),
                    TextEntry::make('judgement_f1')->label('Judgement F1')
                        ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'OK' => 'success',
                                'NG' => 'danger',
                            }),
                    TextEntry::make('f2')->label('F2'),
                    TextEntry::make('judgement_f2')->label('Judgement F2')
                        ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'OK' => 'success',
                                'NG' => 'danger',
                            }),
                ])->columns(2),
                InfolistCard::make([
                    TextEntry::make('remarks')->label('Remarks'),
                    TextEntry::make('created_at')->label('Date')->date(),
                    TextEntry::make('next_date')->label('Next Date')->date(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('packaging.register_no')->label('Packaging')->sortable()->searchable(),
                TextColumn::make('packaging.status')->label('Status')->sortable()->searchable(),
                TextColumn::make('item')->sortable()->searchable(),
                TextColumn::make('f1_scientific')->sortable()->searchable(),
                TextColumn::make('judgement_f1')->sortable()->searchable()
                    ->label('Judgement F1')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                TextColumn::make('f2')->sortable()->searchable(),
                TextColumn::make('judgement_f2')->sortable()->searchable()
                    ->label('Judgement F2')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'OK' => 'success',
                        'NG' => 'danger',
                    }),
                TextColumn::make('remarks')->sortable()->searchable(),
                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('next_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('register_no')
                    ->label('Register No')
                    ->relationship('packaging', 'register_no')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('status')
                    ->label('Status')
                    ->relationship('packaging', 'status')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('item')
                    ->label('Item')
                    ->options(['Tray' => 'Tray', 'Black Box' => 'Black Box'])
                    ->searchable()
                    ->preload(),
                SelectFilter::make('judgement')
                    ->label('Judgement')
                    ->options([
                        'OK' => 'OK',
                        'NG' => 'NG',
                    ]),
                Filter::make('created_at')
                    ->form([
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
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                 
                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }
                 
                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }
                 
                        return $indicators;
                    })
                ])->filtersTriggerAction(
                    fn (Action $action) => $action
                        ->button()
                        ->label('Filter'))
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Export Pdf')
                                ->icon('heroicon-m-arrow-down-tray')
                                ->openUrlInNewTab()
                                ->deselectRecordsAfterCompletion()
                                ->action(function (Collection $records) {
                                    return response()->streamDownload(function () use ($records) {
                                        echo Pdf::loadHTML(
                                            Blade::render('PackagingDetailpdf', ['records' => $records])
                                        )->stream();
                                    }, 'Report_packaging_measurement.pdf');
                                }),
                ExportBulkAction::make()
                    ->label('Export Excel'),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    

    public static function getWidget(): array
    {
        return
        [
            PackagingDetailStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPackagingDetails::route('/'),
            'create' => CreatePackagingDetail::route('/create'),
            'view' => ViewPackagingDetail::route('/{record}'),
            'edit' => EditPackagingDetail::route('/{record}/edit'),
        ];
    }
}
