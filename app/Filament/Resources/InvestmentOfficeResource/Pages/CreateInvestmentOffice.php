<?php

namespace App\Filament\Resources\InvestmentOfficeResource\Pages;

use App\Filament\Resources\InvestmentOfficeResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateInvestmentOffice extends CreateRecord
{
    protected static string $resource = InvestmentOfficeResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;
}
