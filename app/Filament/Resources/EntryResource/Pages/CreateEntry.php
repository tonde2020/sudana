<?php

namespace App\Filament\Resources\EntryResource\Pages;

use App\Filament\Resources\EntryResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateEntry extends CreateRecord
{
    protected static string $resource = EntryResource::class;

    protected Width | string | null $maxContentWidth = Width::Full;
}
