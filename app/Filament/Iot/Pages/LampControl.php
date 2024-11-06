<?php

namespace App\Filament\Iot\Pages;

use Filament\Pages\Page;

class LampControl extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.iot.pages.lamp-control';

    protected static ?string $navigationGroup = 'Smart Lamp';
}
