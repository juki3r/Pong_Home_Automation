<?php

use Illuminate\Support\Facades\Route;

// Route::get('/test-api', function(){
//     return response()->json(['message' => 'Hello API!']);
// });

Route::middleware('check.api')->get('/test-api', function () {
    return response()->json(['message' => 'Welcome! Your API key is valid and you’re subscribed.']);
});
