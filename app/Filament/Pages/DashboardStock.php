<?php

namespace App\Filament\Pages;

class DashboardStock extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard Stock';
    // protected static string $routePath = 'main-menu';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
}
