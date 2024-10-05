<?php

namespace App\Filament\Ga\Resources;

use Filament\Forms;
use App\Models\Area;
use Filament\Tables;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\PengajuanFasilitas;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Card as InfolistCard;
use App\Filament\Ga\Resources\PengajuanFasilitasResource\Pages;
use App\Filament\Ga\Resources\PengajuanFasilitasResource\RelationManagers;

class PengajuanFasilitasResource extends Resource
{
    protected static ?string $model = PengajuanFasilitas::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone-arrow-up-right';

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
                                        $set('dept', $employee->Departement);
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
                            Forms\Components\TextInput::make('dept')
                                ->label('Department')
                                ->required()
                                ->disabled()
                                ->dehydrated(),
                            ToggleButtons::make('jenis_pengajuan_fasilitas')
                                ->options([
                                    'Register Baru Fasilitas' => 'Register Baru Fasilitas',
                                    'Pergantian Fasilitas' => 'Pergantian Fasilitas',
                                    'Pengajuan Perpindahan / Perubahan Area' => 'Pengajuan Perpindahan / Perubahan Area',
                                    'Pengajuan Perpindahan Kepemilikan / User' => 'Pengajuan Perpindahan Kepemilikan / User'
                                ])
                                ->inline(),
                            Forms\Components\Select::make('jenis_fasilitas')
                                ->options([
                                    'Kursi' => 'Kursi',
                                    'Meja' => 'Meja',
                                    'Lemari' => 'Lemari',
                                    'TV' => 'TV',
                                    'Dispenser' => 'Dispenser',
                                    'Papan Tulis' => 'Papan Tulis',
                                    'Laci' => 'Laci',
                                    'Infocus' => 'Infocus',
                                    'Kulkas Besar' => 'Kulkas Besar',
                                    'Kulkas Kecil' => 'Kulkas Kecil',
                                    'Penghancur Kertas' => 'Penghancur Kertas',
                                ]),
                            Forms\Components\TextInput::make('nomor_identitas_fasilitas')
                                ->maxLength(255)
                                ->placeholder('Example : KNT/MPA/2408-113 (Optional Jika Sudah ter-Regist)'),
                            FileUpload::make('foto_fasilitas')
                                ->label('Foto Fasilitas')
                                ->disk('public')
                                ->multiple(),
                            FileUpload::make('foto_lokasi_fasilitas')
                                ->label('Foto Fasilitas')
                                ->disk('public')
                                ->multiple(),
                            Forms\Components\Select::make('lokasi')
                                ->options(Area::all()->pluck('area', 'id'))
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('area')
                                        ->required()
                                        ->label('Tambah Lokasi Jika Tidak tertera di pilihan'),
                                ])
                                ->createOptionUsing(function ($data) {
                                    return Area::create(['area' => $data['area']]);
                                }),                            
                            Forms\Components\TextArea::make('alasan_pengajuan')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\DatePicker::make('due_date')
                                ->required(),
                            Forms\Components\TextArea::make('remarks')
                                ->maxLength(255),
                        ]),                           
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistCard::make([
                    TextEntry::make('nik')
                        ->label('NIK'),
                    TextEntry::make('name'),
                    TextEntry::make('dept'),
                ])->columns(3),
                InfolistCard::make([
                    TextEntry::make('jenis_fasilitas'),
                    TextEntry::make('nomor_identitas_fasilitas'),
                    ImageEntry::make('foto_fasilitas')
                        ->disk('public'),
                    ImageEntry::make('foto_lokasi_fasilitas')
                        ->disk('public'),
                    TextEntry::make('alasan_pengajuan'),
                ])->columns(4),
                InfolistCard::make([
                    TextEntry::make('due_date'),
                    TextEntry::make('remarks')
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenis_pengajuan_fasilitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dept')
                    ->searchable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remarks')
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
                Tables\Actions\DeleteAction::make(),
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
