<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Contribution extends Model
{
    use HasFactory;

    public const TYPE_ENTRY = 'entry';
    public const TYPE_SERVICE = 'service';
    public const TYPE_INVESTMENT = 'investment';
    public const TYPE_STORY = 'story';
    public const TYPE_CORRECTION = 'correction';

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'state_id',
        'locality_id',
        'category_id',
        'submission_type',
        'reviewer_id',
        'contributor_name',
        'contributor_email',
        'contributor_phone',
        'title',
        'content',
        'payload',
        'target_model',
        'target_id',
        'status',
        'review_notes',
        'source_links',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'source_links' => 'array',
            'reviewed_at' => 'datetime',
        ];
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

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function publishToOfficialEntry(?User $reviewer = null): Entry
    {
        $entry = Entry::create([
            'state_id' => $this->state_id,
            'locality_id' => $this->locality_id,
            'category_id' => $this->category_id,
            'author_id' => $reviewer?->id,
            'title' => $this->title,
            'slug' => Str::slug($this->title . '-' . $this->id),
            'excerpt' => Str::limit(strip_tags($this->content), 180),
            'content' => $this->content,
            'status' => Entry::STATUS_PUBLISHED,
            'published_at' => now(),
            'meta' => [
                'source' => 'community_contribution',
                'contribution_id' => $this->id,
                'contributor_name' => $this->contributor_name,
            ],
        ]);

        $this->update([
            'status' => self::STATUS_APPROVED,
            'reviewer_id' => $reviewer?->id,
            'reviewed_at' => now(),
        ]);

        return $entry;
    }
}
