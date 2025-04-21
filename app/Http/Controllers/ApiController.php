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
        // Manually decode JSON if needed
        $rawInput = file_get_contents("php://input");
        $data = json_decode($rawInput, true);  // Decode the JSON payload into an array

        // Check if data is decoded properly
        if ($data === null) {
            return response()->json(['message' => 'Invalid JSON'], 400);
        }

        // Now, manually access the data
        $deviceCode = $data['device_code'] ?? null;
        $gpio = $data['gpio'] ?? null;
        $status = $data['status'] ?? null;
        $switchStatus = $data['switch_status'] ?? null;

        // Example of logic
        return response()->json(['message' => 'Light status updated successfully']);
    }



}
