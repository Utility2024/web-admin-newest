<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LedStatus;
use App\Models\SensorData;

class ApiController extends Controller
{
    // Method to get LED statuses
    public function getData(Request $request)
    {
        $ledStatus = LedStatus::where('id', $request->input('id'))->first();

        if ($ledStatus) {
            return response()->json($ledStatus);
        }

        return response()->json(['error' => 'Data not found'], 404);
    }

    // Method to update sensor data and LED statuses
    public function updateData(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'id' => 'required|string',
            'temperature' => 'required|numeric',
            'humidity' => 'required|integer',
            'status_read_sensor_dht11' => 'required|string',
            'led_01' => 'required|string|in:ON,OFF',
            'led_02' => 'required|string|in:ON,OFF',
            'led_03' => 'required|string|in:ON,OFF',
            'led_04' => 'required|string|in:ON,OFF',
        ]);

        // Save or update LED status
        LedStatus::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'led_01' => $request->input('led_01'),
                'led_02' => $request->input('led_02'),
                'led_03' => $request->input('led_03'),
                'led_04' => $request->input('led_04'),
            ]
        );

        // Save sensor data
        SensorData::create([
            'id' => $request->input('id'),
            'temperature' => $request->input('temperature'),
            'humidity' => $request->input('humidity'),
            'status_read_sensor_dht11' => $request->input('status_read_sensor_dht11'),
        ]);

        return response()->json(['success' => true]);
    }
}

