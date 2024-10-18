<?php

namespace App\Filament\Hr\Resources\EmployeeResource\Widgets;

use Filament\Widgets\Widget;

class CountComelate extends Widget
{
    protected static string $view = 'filament.hr.resources.employee-resource.widgets.count-comelate';

    protected int | string | array $columnSpan = 'full';

    public function getColumnSpan(): string | array | int
    {
        // Mengatur agar widget menggunakan lebar penuh (full width) jika diperlukan
        return 'full';
    }
}
