<?php

use Illuminate\Support\Facades\Route;


//Check Api_key and subscription, if true then this is the functions.
Route::middleware('check.api')->get('/test-api', function () {
    return response()->json(['message' => 'Welcome! Your API key is valid and you’re subscribed.']);
});
