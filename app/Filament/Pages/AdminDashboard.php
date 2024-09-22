<?php

namespace App\Filament\Pages;

class AdminDashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Main Menu';
    // protected static string $routePath = 'main-menu';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
}
