<?php

namespace App\Filament\Hr\Widgets;

use Filament\Tables;
use App\Models\Employee;
use Filament\Tables\Table;
use App\Models\ComelateCount;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\TableWidget as BaseWidget;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class FComelateTable extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Comelate Employee Count';

    public function table(Table $table): Table
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user has the 'SECURITY' role using the isSecurity() method
        if ($user && $user->isSecurity()) {
            // If the user has the 'SECURITY' role, return an empty table or a placeholder
            return $table->query(ComelateCount::query())->columns([]);
        }

        // If the user does not have the 'SECURITY' role, show the table
        return $table
            ->query(ComelateCount::query())
            ->columns([
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('department')
                    ->label('Department')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Tidak Active' => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('count_comelate')
                    ->label('Comelate Count')
                    ->sortable(),
            ])
            ->groups([
                'status',
            ])
            ->actions([
                ViewAction::make()
                    ->label('View')
                    ->url(function (ComelateCount $record): string {
                        $employee = Employee::where('user_login', $record->nik)->first();

                        // Pastikan employee ditemukan
                        if ($employee) {
                            return "/hr/employees/{$employee->ID}";
                        }

                        return "Tidak Ada Data"; // Arahkan ke URL kosong jika data tidak ditemukan
                    }),
            ])
            ->bulkActions([
                    ExportBulkAction::make()
                        ->label('Export Excel'),
            ])
            ->defaultSort('count_comelate', 'desc');
    }
}
