<?php

namespace App\Filament\Wh\Resources\TrayInResource\Widgets;

use Filament\Widgets\Widget;

class WarningWh extends Widget
{
    protected static string $view = 'filament.wh.resources.tray-in-resource.widgets.warning-wh';

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
