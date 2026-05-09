<?php

namespace App\Filament\Resources\InvestmentOfficeResource\Pages;

use App\Filament\Resources\InvestmentOfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditInvestmentOffice extends EditRecord
{
    protected static string $resource = InvestmentOfficeResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
