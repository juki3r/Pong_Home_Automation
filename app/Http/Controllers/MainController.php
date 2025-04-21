<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function show_dashboard()
    {
        return view('dashboard');
    }

    public function show_lights()
    {
        return view('lights.index');
    }

    public function subscribe(Request $request)
    {
        $user = Auth::user();

        // Check if user is already subscribed
        if ($user->subscribe) {
            return redirect()->back()->with('message', 'Already subscribed.');
        }

        // Mark the user as subscribed
        $user->subscribe = true;
        $user->save();

        // If the user does not have a device code, generate one
        if (!$user->device_code) {
            $user->device_code = Str::uuid(); // or use Str::random(16)
            $user->save();
        }

        // Create a new device record for the user (if not already created)
        if (!$user->devices()->exists()) {
            $user->devices()->create([
                'device_code' => $user->device_code,
                'status' => 'offline', // Device initially starts offline
                'last_heartbeat' => now(),
            ]);
        }

        // Avoid duplicating lights
        if ($user->lights()->count() === 0) {
            $gpioPins = [21, 22, 19, 18, 5, 4, 2];  // GPIOs for ESP32
            $defaultLights = [];

            foreach ($gpioPins as $index => $gpio) {
                $defaultLights[] = [
                    'gpio' => (string) $gpio,
                    'switch_name' => 'switch-' . ($index + 1),
                    'action' => 'off',
                    'status' => 'pending',
                    'switch_status' => 'off',
                ];
            }

            $user->lights()->createMany($defaultLights);
        }

        // Avoid duplicating appliances
        if ($user->appliances()->count() === 0) {
            $gpioPins = [21, 22, 19, 18, 5, 4, 2];  // GPIOs for ESP32
            $defaultAppliances = [];

            foreach ($gpioPins as $index => $gpio) {
                $defaultAppliances[] = [
                    'gpio' => (string) $gpio,
                    'switch_name' => 'switch-' . ($index + 1),
                    'action' => 'off',
                    'status' => 'pending',
                    'switch_status' => 'off',
                ];
            }

            $user->appliances()->createMany($defaultAppliances);
        }

        return redirect()->back()->with('message', 'Subscribed successfully!');
    }



}
