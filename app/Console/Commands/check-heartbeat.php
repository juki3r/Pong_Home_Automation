<?php

use Illuminate\Support\Carbon;
use App\Models\Device;

return function () {
    $timeout = 30; // seconds

    $devices = Device::all();

    foreach ($devices as $device) {
        $last = Carbon::parse($device->last_heartbeat);
        $diff = now()->diffInSeconds($last);

        if ($diff > $timeout && $device->status !== 'offline') {
            $device->status = 'offline';
            $device->save();
            echo "Device {$device->device_code} is OFFLINE\n";
        } elseif ($diff <= $timeout && $device->status !== 'online') {
            $device->status = 'online';
            $device->save();
            echo "Device {$device->device_code} is ONLINE\n";
        }
    }
};
