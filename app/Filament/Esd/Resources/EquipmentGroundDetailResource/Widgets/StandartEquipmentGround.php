<?php

namespace App\Filament\Esd\Resources\EquipmentGroundDetailResource\Widgets;

use Filament\Widgets\Widget;

class StandartEquipmentGround extends Widget
{
    protected static string $view = 'filament.esd.widgets.standart-equipment-ground';

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