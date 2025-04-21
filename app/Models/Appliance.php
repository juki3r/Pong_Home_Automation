<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appliance extends Model
{
    protected $fillable = ['gpio', 'switch_name', 'action', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
