<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lights extends Model
{
    protected $fillable = [
        'gpio',
        'switch_name',
        'action',
        'status',
    ];

    // Optional: Cast the status as string for safety
    protected $casts = [
        'status' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
