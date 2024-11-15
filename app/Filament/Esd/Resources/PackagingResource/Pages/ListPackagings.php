<?php

namespace App\Filament\Esd\Resources\PackagingResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Esd\Resources\PackagingResource;

class ListPackagings extends ListRecords
{
    protected static string $resource = PackagingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('customAction')
                ->url('/esd/packaging-details')
                ->label('Go To All Measurement Of Packaging')
                ->color('success')
        ];
    }
}
