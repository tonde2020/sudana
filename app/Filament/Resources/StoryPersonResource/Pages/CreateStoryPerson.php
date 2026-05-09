<?php

namespace App\Filament\Resources\StoryPersonResource\Pages;

use App\Filament\Resources\StoryPersonResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateStoryPerson extends CreateRecord
{
    protected static string $resource = StoryPersonResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;
}
