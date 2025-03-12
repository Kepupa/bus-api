<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Route extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['bus_id', 'direction'];

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function routeStops(): HasMany
    {
        return $this->hasMany(RouteStop::class);
    }

    public function schedule(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    // В модели Route
    public function lastStop(): HasOne
    {
        return $this->hasOne(RouteStop::class)->orderByDesc('stop_order');
    }
}
