<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bus extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['number'];

    public function routes(): HasMany
    {
        return $this->hasMany(Route::class);
    }
}
