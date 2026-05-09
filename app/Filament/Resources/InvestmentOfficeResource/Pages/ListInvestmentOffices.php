<?php

namespace App\Filament\Resources\InvestmentOfficeResource\Pages;

use App\Filament\Resources\InvestmentOfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvestmentOffices extends ListRecords
{
    protected static string $resource = InvestmentOfficeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
