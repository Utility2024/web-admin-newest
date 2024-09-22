<?php

namespace App\Filament\Pages;

class JobsAccess extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Jobs Access';
    // protected static string $routePath = 'main-menu';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
}
