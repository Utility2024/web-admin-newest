<?php

namespace App\Filament\Form\Pages;

use Filament\Pages\Page;

class Token extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.form.pages.token';

    protected static bool $shouldRegisterNavigation = false;
}
