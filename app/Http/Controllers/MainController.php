<?php

namespace App\Http\Controllers;

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

        if ($user->subscribe) {
            return redirect()->back()->with('message', 'Already subscribed.');
        }

        $user->subscribe = true;
        $user->save();

        // Avoid duplicating lights
        if ($user->lights()->count() === 0) {
            $defaultLights = [];
            for ($i = 1; $i <= 7; $i++) {
                $defaultLights[] = [
                    'gpio' => 'D' . $i,
                    'switch_name' => 'switch-' . $i,
                    'action' => 'off',
                    'status' => 'pending'
                ];
            }
            $user->lights()->createMany($defaultLights);
        }

        // Avoid duplicating appliances
        if ($user->appliances()->count() === 0) {
            $defaultAppliances = [];
            for ($i = 1; $i <= 8; $i++) {
                $defaultAppliances[] = [
                    'gpio' => 'D' . $i,
                    'switch_name' => 'appliance-' . $i,
                    'action' => 'off',
                    'status' => 'pending'
                ];
            }
            $user->appliances()->createMany($defaultAppliances);
        }

        return redirect()->back()->with('message', 'Subscribed successfully!');
    }


}
