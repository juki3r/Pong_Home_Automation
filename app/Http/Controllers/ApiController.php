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
        // Validate the incoming request data
        $validated = $request->validate([
            'device_code' => 'required|string',
            'gpio' => 'required|string',
            'status' => 'required|string',
            'switch_status' => 'required|string',
        ]);

        // You can access the data like this
        $deviceCode = $validated['device_code'];
        $gpio = $validated['gpio'];
        $status = $validated['status'];
        $switchStatus = $validated['switch_status'];

        // Implement your logic here (e.g., update GPIO pin or status)
        // Example:
        // if ($status === 'done') { ... }

        // Return a response
        return response()->json(['message' => $deviceCode]);
    }


}
