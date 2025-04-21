<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function testApi(Request $request)
    {
        return response()->json(['message' => 'Welcome!.']);
    }

    public function action(Request $request)
    {
        $deviceCode = $request->query('device_code');

        $user = User::where('device_code', $deviceCode)->first();
    
        if (!$user) {
            return response()->json(['error' => 'Invalid device'], 404);
        }
    
        $pendingLights = $user->lights()->where('status', 'pending')->get();
        $pendingAppliances = $user->appliances()->where('status', 'pending')->get();
    
        return response()->json([
            'pending_lights' => $pendingLights,
            'pending_appliances' => $pendingAppliances
        ]);
    }
}
