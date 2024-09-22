<?php

namespace App\Filament\Pages;

class DashboardGa extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard GA';
    // protected static string $routePath = 'main-menu';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
}
