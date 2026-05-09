<?php

namespace App\Filament\Resources\StoryPersonResource\Pages;

use App\Filament\Resources\StoryPersonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditStoryPerson extends EditRecord
{
    protected static string $resource = StoryPersonResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
