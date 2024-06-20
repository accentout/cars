<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'car_comfort_category_id',
    ];

    /**
     * Get car comfort category by relation.
     *
     * @return BelongsTo
     */
    public function carComfortCategory(): BelongsTo
    {
        return $this->belongsTo(CarComfortCategory::class);
    }

    /**
     * Get cars by relation.
     *
     * @return HasMany
     */
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
