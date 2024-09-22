<?php

namespace App\Filament\Ga\Resources\PengajuanFasilitasResource\Pages;

use App\Filament\Ga\Resources\PengajuanFasilitasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePengajuanFasilitas extends CreateRecord
{
    protected static string $resource = PengajuanFasilitasResource::class;
    
    protected int|string|array $columnSpan = 'full';
}
