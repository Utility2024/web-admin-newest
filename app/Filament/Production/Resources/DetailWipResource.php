<?php

namespace App\Filament\Production\Resources;

use App\Filament\Production\Resources\DetailWipResource\Pages;
use App\Filament\Production\Resources\DetailWipResource\RelationManagers;
use App\Models\DetailWip;
use App\Models\MasterWip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class DetailWipResource extends Resource
{
    protected static ?string $model = DetailWip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Transaction';

    protected static ?string $navigationLabel = 'Data Transaksi WIP';

    protected static bool $shouldRegisterNavigation = false; 

    // Ini adalah tempat di mana kita menentukan apakah navigasi harus didaftarkan
    public static function shouldRegisterNavigation(): bool
    {
        // Mendapatkan role pengguna yang sedang login
        $userRole = auth()->user()->role; // Sesuaikan dengan sistem role yang Anda pakai

        // Tentukan logika berdasarkan role
        if ($userRole === 'isAdminWip') {
            return true;  // Jika role adalah 'isAdminWip', tampilkan navigasi
        } elseif ($userRole === 'isUserWip') {
            return false; // Jika role adalah 'isUserWip', sembunyikan navigasi
        }

        // Default false jika role tidak sesuai
        return false;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('master_wips_id')
                            ->label('Master WIP')
                            ->options(MasterWip::all()->pluck('model', 'id'))
                            ->required(),
                        Forms\Components\TextInput::make('qty')
                            ->label('Quantity')
                            ->required(),
                        Forms\Components\TextInput::make('acm')
                            ->label('ACM')
                            ->required(),
                        Forms\Components\TextInput::make('balance')
                            ->label('Balance')
                            ->required(),
                        Forms\Components\TextInput::make('no_hu')
                            ->label('No HU')
                            ->required(),
                        Forms\Components\TextInput::make('remarks')
                            ->label('Remarks')
                            ->nullable(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('masterwip.model')->label('Model'),
                Tables\Columns\TextColumn::make('qty')->label('Quantity'),
                Tables\Columns\TextColumn::make('acm')->label('ACM'),
                Tables\Columns\TextColumn::make('balance')->label('Balance'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'In Progress' => 'warning',
                        'Finished' => 'success',
                    }), // Add the status column
                Tables\Columns\TextColumn::make('no_hu')->label('No HU')
                    ->wrap(),
                Tables\Columns\TextColumn::make('remarks')->label('Remarks'),
                Tables\Columns\TextColumn::make('created_at')->label('Date')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('creator.name')->label('PIC')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('updater.name')->label('Updated By')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter by fields
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make()
                    ->label('Export Excel'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // If you want to manage related resources here, define relation managers.
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDetailWips::route('/'),
            'create' => Pages\CreateDetailWip::route('/create'),
            'view' => Pages\ViewDetailWip::route('/{record}'),
            'edit' => Pages\EditDetailWip::route('/{record}/edit'),
        ];
    }
}
