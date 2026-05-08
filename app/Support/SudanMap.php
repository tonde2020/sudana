<?php

namespace App\Support;

use App\Models\State;

class SudanMap
{
    public static function build(iterable $states): array
    {
        $statesBySlug = collect($states)->keyBy('slug');

        return collect(self::layout())
            ->map(function (array $item) use ($statesBySlug) {
                $state = $statesBySlug->get($item['slug']);
                $entriesCount = (int) data_get($state, 'entries_count', 0);
                $servicesCount = (int) data_get($state, 'services_count', 0);
                $localitiesCount = (int) data_get($state, 'localities_count', 0);
                $isActive = $state !== null;
                $isComplete = $isActive && ($entriesCount > 0 || $servicesCount > 0);

                return [
                    ...$item,
                    'is_active' => $isActive,
                    'is_complete' => $isComplete,
                    'localities_count' => $localitiesCount,
                    'entries_count' => $entriesCount,
                    'services_count' => $servicesCount,
                    'url' => $isActive ? route('states.show', $item['slug']) : null,
                ];
            })
            ->all();
    }

    public static function databaseStates()
    {
        return State::query()
            ->withCount('localities')
            ->withCount('entries')
            ->withCount('services')
            ->orderBy('name_ar')
            ->get();
    }

    private static function layout(): array
    {
        return [
            ['slug' => 'northern', 'name_ar' => 'الشمالية', 'x' => 250, 'y' => 90, 'label_dx' => 0, 'label_dy' => -18, 'label_anchor' => 'middle'],
            ['slug' => 'red-sea', 'name_ar' => 'البحر الأحمر', 'x' => 390, 'y' => 155, 'label_dx' => 18, 'label_dy' => -8, 'label_anchor' => 'start'],
            ['slug' => 'river-nile', 'name_ar' => 'نهر النيل', 'x' => 285, 'y' => 180, 'label_dx' => 0, 'label_dy' => -18, 'label_anchor' => 'middle'],
            ['slug' => 'north-darfur', 'name_ar' => 'شمال دارفور', 'x' => 120, 'y' => 220, 'label_dx' => -18, 'label_dy' => -8, 'label_anchor' => 'end'],
            ['slug' => 'kassala', 'name_ar' => 'كسلا', 'x' => 410, 'y' => 245, 'label_dx' => 18, 'label_dy' => 4, 'label_anchor' => 'start'],
            ['slug' => 'khartoum', 'name_ar' => 'الخرطوم', 'x' => 285, 'y' => 270, 'label_dx' => -18, 'label_dy' => 4, 'label_anchor' => 'end'],
            ['slug' => 'gezira', 'name_ar' => 'الجزيرة', 'x' => 315, 'y' => 315, 'label_dx' => 18, 'label_dy' => 4, 'label_anchor' => 'start'],
            ['slug' => 'gedaref', 'name_ar' => 'القضارف', 'x' => 390, 'y' => 330, 'label_dx' => 18, 'label_dy' => 4, 'label_anchor' => 'start'],
            ['slug' => 'west-darfur', 'name_ar' => 'غرب دارفور', 'x' => 70, 'y' => 340, 'label_dx' => -18, 'label_dy' => 4, 'label_anchor' => 'end'],
            ['slug' => 'north-kordofan', 'name_ar' => 'شمال كردفان', 'x' => 190, 'y' => 350, 'label_dx' => -18, 'label_dy' => -8, 'label_anchor' => 'end'],
            ['slug' => 'sennar', 'name_ar' => 'سنار', 'x' => 315, 'y' => 385, 'label_dx' => 18, 'label_dy' => 4, 'label_anchor' => 'start'],
            ['slug' => 'central-darfur', 'name_ar' => 'وسط دارفور', 'x' => 110, 'y' => 405, 'label_dx' => -18, 'label_dy' => 4, 'label_anchor' => 'end'],
            ['slug' => 'west-kordofan', 'name_ar' => 'غرب كردفان', 'x' => 190, 'y' => 430, 'label_dx' => -18, 'label_dy' => 4, 'label_anchor' => 'end'],
            ['slug' => 'blue-nile', 'name_ar' => 'النيل الأزرق', 'x' => 365, 'y' => 450, 'label_dx' => 18, 'label_dy' => 4, 'label_anchor' => 'start'],
            ['slug' => 'white-nile', 'name_ar' => 'النيل الأبيض', 'x' => 270, 'y' => 460, 'label_dx' => 0, 'label_dy' => 24, 'label_anchor' => 'middle'],
            ['slug' => 'east-darfur', 'name_ar' => 'شرق دارفور', 'x' => 135, 'y' => 485, 'label_dx' => -18, 'label_dy' => 18, 'label_anchor' => 'end'],
            ['slug' => 'south-kordofan', 'name_ar' => 'جنوب كردفان', 'x' => 220, 'y' => 515, 'label_dx' => -18, 'label_dy' => 18, 'label_anchor' => 'end'],
            ['slug' => 'south-darfur', 'name_ar' => 'جنوب دارفور', 'x' => 110, 'y' => 560, 'label_dx' => -18, 'label_dy' => 18, 'label_anchor' => 'end'],
        ];
    }
}
