<?php

namespace App\Filament\Resources\VirtualTourResource\Pages;

use App\Filament\Resources\VirtualTourResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateVirtualTour extends CreateRecord
{
    protected static string $resource = VirtualTourResource::class;

    protected Width | string | null $maxContentWidth = Width::Full;
}
