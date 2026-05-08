<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VirtualTour extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'state_id',
        'locality_id',
        'entry_id',
        'title',
        'slug',
        'excerpt',
        'panorama_path',
        'preview_image_path',
        'status',
        'is_featured',
        'sort_order',
        'meta',
        'published_at',
    ];

    protected $appends = [
        'panorama_url',
        'preview_image_url',
        'panorama_is_compatible',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'meta' => 'array',
            'published_at' => 'datetime',
        ];
    }

    protected function panoramaUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset('storage/' . ltrim($this->panorama_path, '/')),
        );
    }

    protected function previewImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->preview_image_path
                ? asset('storage/' . ltrim($this->preview_image_path, '/'))
                : data_get($this->meta, 'image'),
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

        return $ratio >= 1.95 && $ratio <= 2.05;
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function locality(): BelongsTo
    {
        return $this->belongsTo(Locality::class);
    }

    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }
}
