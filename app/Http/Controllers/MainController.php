<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
