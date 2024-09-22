<?php

namespace App\Filament\Pages;

class DashboardForm extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'All Form Application';
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
}
