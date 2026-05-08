<?php

namespace App\Filament\Resources\StateResource\Pages;

use App\Filament\Resources\StateResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateState extends CreateRecord
{
    protected static string $resource = StateResource::class;

    protected Width | string | null $maxContentWidth = Width::Full;
}
