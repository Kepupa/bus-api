<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stop extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name'];

    public function routeStops()
    {
        return $this->hasMany(RouteStop::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}

