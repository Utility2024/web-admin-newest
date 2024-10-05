<?php

namespace App\Filament\Pages;

class DashboardWh extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard Control Tray WH ';
    // protected static string $routePath = 'main-menu';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
}
