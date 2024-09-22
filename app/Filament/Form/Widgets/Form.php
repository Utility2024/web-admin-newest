<?php

namespace App\Filament\Form\Widgets;

use Filament\Widgets\Widget;

class Form extends Widget
{
    protected static string $view = 'filament.form.widgets.form';

    protected int | string | array $columnSpan = 'full';
}
