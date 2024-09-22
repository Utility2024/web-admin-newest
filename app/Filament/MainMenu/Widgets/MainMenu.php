<?php

namespace App\Filament\MainMenu\Widgets;

use Filament\Widgets\Widget;

class MainMenu extends Widget
{
    protected static string $view = 'filament.main-menu.widgets.main-menu';

    protected int | string | array $columnSpan = 'full';
}
