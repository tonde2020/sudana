<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvestmentOffice extends Model
{
    use HasFactory;
    use HasLocalizedAttributes;

    protected $fillable = [
        'state_id',
        'name_ar',
        'name_en',
        'name_fr',
        'slug',
        'description_ar',
        'description_en',
        'description_fr',
        'contact_name',
        'email',
        'phone',
        'whatsapp',
        'address_ar',
        'address_en',
        'address_fr',
        'website_url',
        'working_hours',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function opportunities(): HasMany
    {
        return $this->hasMany(InvestmentOpportunity::class, 'office_id');
    }
}
