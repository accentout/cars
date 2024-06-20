<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get users by relation.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get car comfort categories by relation.
     *
     * @return BelongsToMany
     */
    public function carComfortCategories(): BelongsToMany
    {
        return $this->belongsToMany(CarComfortCategory::class, 'position_comfort_category',
            'position_id', 'car_comfort_category_id');
    }
}
