<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DirectoryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name_ar' => 'التاريخ', 'name_en' => 'History', 'icon' => 'heroicon-o-book-open'],
            ['name_ar' => 'المعالم', 'name_en' => 'Landmarks', 'icon' => 'heroicon-o-map'],
            ['name_ar' => 'الشخصيات البارزة', 'name_en' => 'Notable Figures', 'icon' => 'heroicon-o-user-group'],
            ['name_ar' => 'الاستثمار', 'name_en' => 'Investment', 'icon' => 'heroicon-o-banknotes'],
            ['name_ar' => 'الفرص الاستثمارية', 'name_en' => 'Investment Opportunities', 'icon' => 'heroicon-o-building-library'],
            ['name_ar' => 'الخدمات', 'name_en' => 'Services', 'icon' => 'heroicon-o-building-office-2'],
            ['name_ar' => 'الطوارئ', 'name_en' => 'Emergency', 'icon' => 'heroicon-o-phone'],
            ['name_ar' => 'الحكايات والنوادر', 'name_en' => 'Stories and Anecdotes', 'icon' => 'heroicon-o-chat-bubble-left-right'],
            ['name_ar' => 'الأحاجي والأمثال', 'name_en' => 'Riddles and Proverbs', 'icon' => 'heroicon-o-sparkles'],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['slug' => Str::slug($category['name_en'])],
                [
                    'name_ar' => $category['name_ar'],
                    'name_en' => $category['name_en'],
                    'icon' => $category['icon'],
                    'is_active' => true,
                ],
            );
        }
    }
}
