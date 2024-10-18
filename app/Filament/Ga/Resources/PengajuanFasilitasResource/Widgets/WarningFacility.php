<?php

namespace App\Filament\Ga\Resources\PengajuanFasilitasResource\Widgets;

use Filament\Widgets\Widget;

class WarningFacility extends Widget
{
    protected static string $view = 'filament.ga.resources.pengajuan-fasilitas-resource.widgets.warning-facility';

    protected int | string | array $columnSpan = 'full';

    public function getColumnSpan(): string | array | int
    {
        // Mengatur agar widget menggunakan lebar penuh (full width) jika diperlukan
        return 'full';
    }

    public function isFullWidth(): bool
    {
        // Mengatur agar widget menggunakan lebar penuh
        return true;
    }
}
