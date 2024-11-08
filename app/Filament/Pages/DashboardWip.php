<?php

namespace App\Filament\Pages;

class DashboardWip extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard WIP Transfer Project ';

    protected static ?string $navigationLabel = 'Dashboard';
    // protected static string $routePath = 'main-menu';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
}
