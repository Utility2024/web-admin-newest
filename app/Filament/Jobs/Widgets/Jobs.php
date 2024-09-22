<?php

namespace App\Filament\Jobs\Widgets;

use Filament\Widgets\Widget;

class Jobs extends Widget
{
    protected static string $view = 'filament.jobs.widgets.jobs';

    protected int | string | array $columnSpan = 'full';
}
