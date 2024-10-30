<?php

namespace App\Http\Controllers;

use App\Models\Led;
use Illuminate\Http\Request;

class LedController extends Controller
{
    public function index()
    {
        $leds = Led::first(); // Load the first entry
        return view('filament.led-control', compact('leds'));
    }

    public function toggle(Request $request, $led)
    {
        $ledStatus = Led::first();
        $ledStatus->{$led} = !$ledStatus->{$led}; // Toggle the LED state
        $ledStatus->save(); // Save the updated state

        return redirect()->route('filament.led-control'); // Redirect back to the page
    }
}
