<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function testApi(Request $request)
    {
        return response()->json(['message' => 'Welcome!.']);
    }
}
