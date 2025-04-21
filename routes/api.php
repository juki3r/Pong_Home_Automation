<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DeviceController;


//Check Api_key and subscription, if true then this is the functions.
Route::middleware('check.api')->group(function(){
    Route::get('/test-api', [ApiController::class, 'testApi']);

    //TO ESP8266
    Route::get('/fetch-pending-actions-lights', [ApiController::class, 'action_lights']);
    Route::get('/fetch-pending-actions-appliance', [ApiController::class, 'action_appliance']);
    Route::post('/update-light-status', [ApiController::class, 'updateLightStatus']);

    Route::post('device-heartbeat', [DeviceController::class, 'handleHeartbeat']);
});



