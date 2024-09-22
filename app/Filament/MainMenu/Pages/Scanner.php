<?php

namespace App\Filament\MainMenu\Pages;

use Filament\Pages\Page;

class Scanner extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.main-menu.pages.scanner';

    protected static bool $shouldRegisterNavigation = false;
}
