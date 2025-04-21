<?php

use App\Models\Device;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(function () {
    Device::all()->each(function ($device) {
        if ($device->last_heartbeat && now()->diffInSeconds($device->last_heartbeat) > 30) {
            $device->status = 'offline';
            $device->save();
        }
    });
})->everyMinute();