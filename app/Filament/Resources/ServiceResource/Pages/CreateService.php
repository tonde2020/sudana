<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected Width | string | null $maxContentWidth = Width::Full;
}
