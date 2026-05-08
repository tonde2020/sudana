<?php

namespace App\Filament\Resources\ContributionResource\Pages;

use App\Filament\Resources\ContributionResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateContribution extends CreateRecord
{
    protected static string $resource = ContributionResource::class;

    protected Width | string | null $maxContentWidth = Width::Full;
}
