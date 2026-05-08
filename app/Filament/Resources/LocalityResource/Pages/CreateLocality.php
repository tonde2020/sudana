<?php

namespace App\Filament\Resources\LocalityResource\Pages;

use App\Filament\Resources\LocalityResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateLocality extends CreateRecord
{
    protected static string $resource = LocalityResource::class;

    protected Width | string | null $maxContentWidth = Width::Full;
}
