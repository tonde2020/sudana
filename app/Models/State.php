<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $appends = [
        'logo_url',
        'hero_image_url',
    ];

    protected $fillable = [
        'name_ar',
        'name_en',
        'slug',
        'capital',
        'summary',
        'history',
        'emblem_path',
        'hero_image_path',
        'latitude',
        'longitude',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function localities(): HasMany
    {
        return $this->hasMany(Locality::class);
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

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function virtualTours(): HasMany
    {
        return $this->hasMany(VirtualTour::class);
    }

    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->emblem_path
                ? asset('storage/' . ltrim($this->emblem_path, '/'))
                : asset('images/state-placeholder.svg'),
        );
    }

    protected function heroImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hero_image_path
                ? asset('storage/' . ltrim($this->hero_image_path, '/'))
                : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1600&q=80',
        );
    }
}
