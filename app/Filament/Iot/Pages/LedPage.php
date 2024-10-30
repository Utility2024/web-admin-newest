<?php

namespace App\Filament\Iot\Pages;

use App\Models\Led;
use Filament\Pages\Page;

class LedPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.iot.pages.led';
    protected static ?string $navigationLabel = 'LED';
    protected static ?string $navigationGroup = 'Smart Office';

    public $leds; // Declare the property to hold LED data

    public function getTitle(): string
    {
        return "Smart Lamp";
    }

    public function mount() // This method runs before rendering the view
    {
        $this->leds = Led::first(); // Load the first LED entry
    }

    public function toggle($led)
    {
        $ledStatus = Led::first();
        $ledStatus->{$led} = !$ledStatus->{$led}; // Toggle the LED state
        $ledStatus->save(); // Save the updated state

        return redirect()->route('filament.iot.led'); // Redirect back to the page
    }
}
