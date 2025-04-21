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

    

    




}
