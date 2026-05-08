<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Locality extends Model
{
    use HasFactory;

    protected $fillable = [
        'state_id',
        'name_ar',
        'name_en',
        'slug',
        'summary',
        'description',
        'population_estimate',
        'area_km2',
        'latitude',
        'longitude',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'population_estimate' => 'integer',
            'area_km2' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_published' => 'boolean',
        ];
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(Contribution::class);
    }

    public function virtualTours(): HasMany
    {
        return $this->hasMany(VirtualTour::class);
    }
}
