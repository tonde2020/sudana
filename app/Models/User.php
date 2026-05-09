<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'state_id',
        'name',
        'email',
        'phone',
        'password',
        'role',
        'bio',
        'volunteer_skills',
        'application_status',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'volunteer_skills' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class, 'author_id');
    }

    public function reviewedContributions(): HasMany
    {
        return $this->hasMany(Contribution::class, 'reviewer_id');
    }

    public function reviewedInvestmentOpportunities(): HasMany
    {
        return $this->hasMany(InvestmentOpportunity::class, 'reviewer_id');
    }

    public function reviewedStories(): HasMany
    {
        return $this->hasMany(Story::class, 'reviewer_id');
    }

    public function reviewedStoryPeople(): HasMany
    {
        return $this->hasMany(StoryPerson::class, 'reviewer_id');
    }
}
