<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lights;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function testApi(Request $request)
    {
        return response()->json(['message' => 'Welcome!.']);
    }

    public function action_lights(Request $request)
    {
        $deviceCode = $request->query('device_code');

        $user = User::where('device_code', $deviceCode)->first();
    
        if (!$user) {
            return response()->json(['error' => 'Invalid device'], 404);
        }
    
        $pendingLights = $user->lights()->where('status', 'pending')->get();
    
        return response()->json([
            'pending_lights' => $pendingLights,
        ]);
    }

    public function action_appliance(Request $request)
    {
        $deviceCode = $request->query('device_code');

        $user = User::where('device_code', $deviceCode)->first();
    
        if (!$user) {
            return response()->json(['error' => 'Invalid device'], 404);
        }
        $pendingAppliances = $user->appliances()->where('status', 'pending')->get();
    
        return response()->json([
            'pending_appliances' => $pendingAppliances
        ]);
    }

    public function updateLightStatus(Request $request)
    {
        // Read raw JSON input
        $rawInput = file_get_contents("php://input");
        $data = json_decode($rawInput, true);
    
        if ($data === null) {
            return response()->json(['message' => 'Invalid JSON', 'raw_input' => $rawInput], 400);
        }
    
        $deviceCode = $data['device_code'] ?? null;
        $gpio = $data['gpio'] ?? null;
        $status = $data['status'] ?? null;
        $switchStatus = $data['switch_status'] ?? null;
    
        // Validate required data
        if (!$deviceCode || !$gpio || $status === null || $switchStatus === null) {
            return response()->json(['message' => 'Missing required fields'], 400);
        }
    
        // Find the user by device code
        $user = User::where('device_code', $deviceCode)->first();
    
        if (!$user) {
            return response()->json(['message' => 'Device not found'], 404);
        }
    
        // Find the light by GPIO
        $light = $user->lights()->where('gpio', $gpio)->first();
    
        if (!$light) {
            return response()->json(['message' => 'Light with GPIO ' . $gpio . ' not found'], 404);
        }
    
        // Update the light status
        $light->update([
            'status' => $status,
            'switch_status' => $switchStatus,
        ]);
    
        return response()->json(['message' => 'Light status updated successfully']);
    }

    //Device heartbeat
    public function deviceHeartbeat(Request $request)
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
