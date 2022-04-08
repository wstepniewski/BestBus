<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    public function times()
    {
        return $this->hasMany(Time::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
