<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['bus_id', 'direction'];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function routeStops()
    {
        return $this->hasMany(RouteStop::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    // В модели Route
    public function lastStop()
    {
        return $this->hasOne(RouteStop::class)->orderByDesc('stop_order');
    }
}

