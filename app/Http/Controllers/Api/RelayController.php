<?php

namespace App\Http\Controllers\Api;

use App\Models\Relay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Broadcast;

class RelayController extends Controller
{
    public function getRelaysStatus()
    {
        return Relay::all(); // Mengembalikan status semua relay
    }

    public function updateRelayStatus(Request $request, $relayNumber)
    {
        $relay = Relay::where('relay_number', $relayNumber)->first();

        if ($relay) {
            $relay->status = $request->input('status');
            $relay->save();

            // Broadcast status yang diperbarui
            broadcast(new \App\Events\RelayStatusUpdated($relay)); // Broadcast event

            return response()->json(['message' => 'Relay diperbarui dengan sukses.']);
        }

        return response()->json(['message' => 'Relay tidak ditemukan.'], 404);
    }
}
