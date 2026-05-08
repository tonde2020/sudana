<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entry extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING_REVIEW = 'pending_review';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'state_id',
        'locality_id',
        'category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'panorama_path',
        'status',
        'is_featured',
        'view_count',
        'published_at',
        'meta',
    ];

    protected $appends = [
        'panorama_url',
        'panorama_is_compatible',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'view_count' => 'integer',
            'published_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    protected function panoramaUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->panorama_path
                ? asset('storage/' . ltrim($this->panorama_path, '/'))
                : null,
        );
    }

    protected function panoramaIsCompatible(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->isPanoramaCompatible(),
        );
    }

    public function isPanoramaCompatible(): bool
    {
        if (! $this->panorama_path) {
            return false;
        }

        $absolutePath = public_path('storage/' . ltrim($this->panorama_path, '/'));

        if (! is_file($absolutePath)) {
            return false;
        }

        $dimensions = @getimagesize($absolutePath);

        if (! is_array($dimensions) || empty($dimensions[0]) || empty($dimensions[1])) {
            return false;
        }

        $ratio = $dimensions[0] / $dimensions[1];

        // Equirectangular ~2:1 (allow common camera exports slightly off square)
        return $ratio >= 1.9 && $ratio <= 2.12;
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function locality(): BelongsTo
    {
        return $this->belongsTo(Locality::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function virtualTours(): HasMany
    {
        return $this->hasMany(VirtualTour::class);
    }
}
