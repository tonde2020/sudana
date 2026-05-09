<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoryPerson extends Model
{
    use HasFactory;
    use HasLocalizedAttributes;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING_REVIEW = 'pending_review';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'state_id',
        'locality_id',
        'reviewer_id',
        'name_ar',
        'name_en',
        'name_fr',
        'slug',
        'headline_ar',
        'headline_en',
        'headline_fr',
        'bio_ar',
        'bio_en',
        'bio_fr',
        'image_path',
        'birth_year',
        'death_year',
        'source_name',
        'source_url',
        'status',
        'is_featured',
        'published_at',
        'verified_at',
        'review_notes',
    ];

    protected function casts(): array
    {
        return [
            'birth_year' => 'integer',
            'death_year' => 'integer',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function locality(): BelongsTo
    {
        return $this->belongsTo(Locality::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function stories(): HasMany
    {
        return $this->hasMany(Story::class);
    }
}
