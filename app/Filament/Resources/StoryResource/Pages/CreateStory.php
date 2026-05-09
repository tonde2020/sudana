<?php

namespace App\Filament\Resources\StoryResource\Pages;

use App\Filament\Resources\StoryResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateStory extends CreateRecord
{
    protected static string $resource = StoryResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;
}
