<?php

namespace App\Filament\Resources\StoryPersonResource\Pages;

use App\Filament\Resources\StoryPersonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStoryPeople extends ListRecords
{
    protected static string $resource = StoryPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
