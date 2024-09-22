<?php

namespace App\Filament\Esd\Pages;

use Filament\Pages\Page;

class ScanQrCode extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static string $view = 'filament.esd.pages.scan';
}
