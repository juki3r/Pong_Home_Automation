<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_code', 'user_id', 'status', 'last_heartbeat'
    ];

    // A device belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
