<?php

namespace App\Filament\Ga\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DataFasilitas;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Blade;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Ga\Resources\DataFasilitasResource\Pages;
use App\Filament\Ga\Resources\DataFasilitasResource\RelationManagers;
use Filament\Forms\Components\ToggleButtons;

class DataFasilitasResource extends Resource
{
    protected static ?string $model = DataFasilitas::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Facility';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('area_id')
                            ->relationship('area', 'area')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'category')
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('register_no')
                            ->required()
                            ->maxLength(255),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No.'),
                Tables\Columns\TextColumn::make('area.area')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.category')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('register_no')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Register No copied')
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Use' => 'success',
                        'Not Use' => 'warning',
                        'Lost And Scrap' => 'danger'
                    })
                    ->sortable(),
                // Tables\Columns\TextColumn::make('qr_code')
                //     ->label('QR Code')
                //     ->html()
                //     ->getStateUsing(function ($record) {
                //         $qrCode = base64_encode(QrCode::format('svg')->size(100)->generate($record->register_no));
                //         return "<img src='data:image/svg+xml;base64,{$qrCode}' alt='QR Code' />";
                //     }),
                Tables\Columns\TextColumn::make('created_by')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_by')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('area')
                ->relationship('area', 'area')
                ->label('Area')
                ->preload()
            ])
            ->actions([
                Tables\Actions\Action::make('edit_status')
                    ->label('Edit Status')
                    ->icon('heroicon-o-pencil')
                    ->action(function ($record, array $data) {
                        $record->update(['status' => $data['status']]);
                    })
                    ->form([
                        ToggleButtons::make('status')
                            ->options([
                                'Use' => 'Use',
                                'Not Use' => 'Not Use',
                                'Lost And Scrap' => 'Lost And Scrap',
                            ])
                            ->colors([
                                'Use' => 'success',
                                'Not Use' => 'warning',
                                'Lost And Scrap' => 'danger',
                            ])
                            ->inline()
                            ->required(),
                    ]),
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
                                    Blade::render('DataRegisterpdf', ['records' => $records])
                                )->stream();
                            }, 'DataRegister.pdf');
                        }),
                ExportBulkAction::make()
                    ->label('Export Excel'),
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDataFasilitas::route('/'),
            'create' => Pages\CreateDataFasilitas::route('/create'),
            'view' => Pages\ViewDataFasilitas::route('/{record}'),
            'edit' => Pages\EditDataFasilitas::route('/{record}/edit'),
        ];
    }
}
