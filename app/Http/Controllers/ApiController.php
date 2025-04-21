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
        // Read the raw input from the body
        $rawInput = file_get_contents("php://input");

        // Attempt to decode the raw input JSON
        $data = json_decode($rawInput, true);

        // If json_decode fails, it returns null
        if ($data === null) {
            return response()->json(['message' => 'Invalid JSON', 'raw_input' => $rawInput], 400);
        }

        // Now, you should have access to $data as an associative array
        $deviceCode = $data['device_code'] ?? null;
        $gpio = $data['gpio'] ?? null;
        $status = $data['status'] ?? null;
        $switchStatus = $data['switch_status'] ?? null;

        // Example logic here (e.g., GPIO update, database interaction, etc.)
        return response()->json(['message' => 'Light status updated successfully']);
    }




}
