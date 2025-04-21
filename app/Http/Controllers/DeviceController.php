<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    //Device heartbeat
    public function handleHeartbeat(Request $request)
    {
        // Read the raw input from the body
        $rawInput = file_get_contents("php://input");

        // Attempt to decode the raw input JSON
        $data = json_decode($rawInput, true);

        // If json_decode fails, it returns null
        if ($data === null) {
            return response()->json(['message' => 'Invalid JSON', 'raw_input' => $rawInput], 400);
        }

        // Get the device code and status (online/offline)
        $deviceCode = $data['device_code'] ?? null;
        $status = $data['status'] ?? null;

        if ($deviceCode && $status) {
            // Store the current timestamp as the last heartbeat for this device
            $device = Device::where('device_code', $deviceCode)->first();

            if ($device) {
                $device->last_heartbeat = now();  // Update the timestamp
                $device->status = $status;  // Update the status (online/offline)
                $device->save();
            } else {
                // If the device doesn't exist, create a new record
                Device::create([
                    'device_code' => $deviceCode,
                    'status' => $status,
                    'last_heartbeat' => now(),
                ]);
            }

            return response()->json(['message' => 'Heartbeat received']);
        }

        return response()->json(['message' => 'Device code or status missing'], 400);
    }
}
