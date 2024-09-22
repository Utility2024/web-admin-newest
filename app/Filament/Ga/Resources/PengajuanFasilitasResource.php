<?php

namespace App\Filament\Ga\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\PengajuanFasilitas;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Ga\Resources\PengajuanFasilitasResource\Pages;
use App\Filament\Ga\Resources\PengajuanFasilitasResource\RelationManagers;
use Filament\Forms\Components\Tabs;

class PengajuanFasilitasResource extends Resource
{
    protected static ?string $model = PengajuanFasilitas::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone-arrow-up-right';

    protected static ?string $navigationGroup = 'Facility';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Pengajuan')
                    ->tabs([
                        Tabs\Tab::make('Data Personal')
                            ->icon('heroicon-m-user')
                                ->schema([
                                    Forms\Components\TextInput::make('nik')
                                        ->required()
                                        ->label('NIK')
                                        ->numeric(),
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('dept')
                                        ->required()
                                        ->maxLength(255),
                                    ]),
                        Tabs\Tab::make('Pengajuan')
                            ->icon('heroicon-m-phone-arrow-up-right')
                                ->schema([
                                    ToggleButtons::make('jenis_pengajuan_fasilitas')
                                        ->options([
                                            'Register Baru Fasilitas' => 'Register Baru Fasilitas',
                                            'Pergantian Fasilitas' => 'Pergantian Fasilitas',
                                            'Pengajuan Perpindahan / Perubahan Area' => 'Pengajuan Perpindahan / Perubahan Area',
                                            'Pengajuan Perpindahan Kepemilikan / User' => 'Pengajuan Perpindahan Kepemilikan / User'
                                        ]),
                                        Forms\Components\TextInput::make('jenis_fasilitas')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('nomor_identitas_fasilitas')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('foto_fasilitas')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('foto_lokasi_fasilitas')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('lokasi')
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                        Tabs\Tab::make('Alasan')
                            ->icon('heroicon-m-question-mark-circle')
                                ->schema([
                                    Forms\Components\TextArea::make('alasan_pengajuan')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\DatePicker::make('due_date')
                                        ->required(),
                                    Forms\Components\TextArea::make('remarks')
                                        ->maxLength(255),
                                    ]),                           
                                            
                        ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenis_pengajuan_fasilitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dept')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_fasilitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_identitas_fasilitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foto_fasilitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foto_lokasi_fasilitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alasan_pengajuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->searchable(),
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
                //
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
            'index' => Pages\ListPengajuanFasilitas::route('/'),
            'create' => Pages\CreatePengajuanFasilitas::route('/create'),
            'view' => Pages\ViewPengajuanFasilitas::route('/{record}'),
            'edit' => Pages\EditPengajuanFasilitas::route('/{record}/edit'),
        ];
    }
}
