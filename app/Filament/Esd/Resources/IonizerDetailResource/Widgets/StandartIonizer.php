<?php

namespace App\Filament\Esd\Resources\IonizerDetailResource\Widgets;

use Filament\Widgets\Widget;

class StandartIonizer extends Widget
{
    protected static string $view = 'filament.esd.widgets.standart-ionizer';

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
