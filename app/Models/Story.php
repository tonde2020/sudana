<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Story extends Model
{
    use HasFactory;
    use HasLocalizedAttributes;

    public const TYPE_STORY = 'story';
    public const TYPE_ANECDOTE = 'anecdote';
    public const TYPE_RIDDLE = 'riddle';
    public const TYPE_PROVERB = 'proverb';
    public const TYPE_BIOGRAPHY = 'biography';

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING_REVIEW = 'pending_review';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'state_id',
        'locality_id',
        'story_person_id',
        'reviewer_id',
        'story_type',
        'title_ar',
        'title_en',
        'title_fr',
        'slug',
        'summary_ar',
        'summary_en',
        'summary_fr',
        'content_ar',
        'content_en',
        'content_fr',
        'interpretation_ar',
        'interpretation_en',
        'interpretation_fr',
        'narrator_name',
        'source_name',
        'source_url',
        'audio_path',
        'image_path',
        'audience_age_group',
        'status',
        'is_featured',
        'published_at',
        'verified_at',
        'review_notes',
    ];

    protected function casts(): array
    {
        return [
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

    public function person(): BelongsTo
    {
        return $this->belongsTo(StoryPerson::class, 'story_person_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
