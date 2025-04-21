<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;


//Check Api_key and subscription, if true then this is the functions.
Route::middleware('check.api')->group(function(){
    Route::get('/test-api', [ApiController::class, 'testApi']);
});