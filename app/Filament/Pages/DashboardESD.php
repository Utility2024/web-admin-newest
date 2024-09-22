<?php

namespace App\Filament\Pages;

class DashboardESD extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard ESD';
    // protected static string $routePath = 'main-menu';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
}
