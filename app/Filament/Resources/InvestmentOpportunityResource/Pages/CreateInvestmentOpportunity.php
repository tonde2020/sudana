<?php

namespace App\Filament\Resources\InvestmentOpportunityResource\Pages;

use App\Filament\Resources\InvestmentOpportunityResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateInvestmentOpportunity extends CreateRecord
{
    protected static string $resource = InvestmentOpportunityResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;
}
