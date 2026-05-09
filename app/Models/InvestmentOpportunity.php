<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentOpportunity extends Model
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
        'category_id',
        'office_id',
        'reviewer_id',
        'title_ar',
        'title_en',
        'title_fr',
        'slug',
        'summary_ar',
        'summary_en',
        'summary_fr',
        'description_ar',
        'description_en',
        'description_fr',
        'investment_type',
        'readiness_status',
        'capital_range',
        'expected_roi_notes',
        'infrastructure_notes_ar',
        'infrastructure_notes_en',
        'infrastructure_notes_fr',
        'incentives_ar',
        'incentives_en',
        'incentives_fr',
        'risks_ar',
        'risks_en',
        'risks_fr',
        'latitude',
        'longitude',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_whatsapp',
        'attachment_path',
        'image_path',
        'status',
        'is_featured',
        'published_at',
        'source_name',
        'source_url',
        'verified_at',
        'review_notes',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(InvestmentOffice::class, 'office_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
