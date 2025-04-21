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

    //UPDATE LIGHT STATUS
    public function updateLightStatus(Request $request)
    {
        // $request->validate([
        //     'device_code' => 'required|string',
        //     'gpio' => 'required|string',
        //     'status' => 'required|in:pending,done',
        //     'switch_status' => 'required|string',
        // ]);

        // // Find the switch by device code and GPIO
        // $light = DB::table('lights')
        //         ->join('users', 'users.id', '=', 'lights.user_id')
        //         ->where('users.device_code', $request->device_code)
        //         ->where('lights.gpio', $request->gpio)
        //         ->select('lights.*') // or lights.id only if needed
        //         ->first();

        //     if (!$light) {
        //         return response()->json(['message' => 'Switch not found'], 404);
        //     }

        //     DB::table('lights')->where('id', $light->id)->update([
        //         'status' => $request->status,
        //         'switch_status' => $request->switch_status,
        //         'updated_at' => now(),
        //     ]);

            return response()->json(['message' => 'Switch status updated to ' . $request->device_code]);


    }


}
