<?php

namespace App\Support;

/**
 * بيانات الولايات للصفحة الرئيسية وصفحة البوابة (حتى ربط قاعدة البيانات).
 */
class SudanStateCatalog
{
    /** @return list<object{slug: string, name_ar: string, localities_count: int, logo_url: string}> */
    public static function forHomepage(): array
    {
        return collect(self::baseList())
            ->map(fn (array $row, string $slug) => (object) [
                'slug' => $slug,
                'name_ar' => $row['name_ar'],
                'localities_count' => $row['localities_count'],
                'logo_url' => asset('images/state-placeholder.svg'),
            ])
            ->values()
            ->all();
    }

    public static function portalState(string $slug): ?object
    {
        $base = self::baseList()[$slug] ?? null;
        if ($base === null) {
            return null;
        }

        $defaults = self::defaultPortalFields();
        $rich = self::portalRichContent()[$slug] ?? [];

        return (object) array_merge($defaults, $base, $rich, [
            'slug' => $slug,
            'logo' => $rich['logo'] ?? $defaults['logo'],
        ]);
    }

    /** @return array<string, array{name_ar: string, localities_count: int}> */
    private static function baseList(): array
    {
        return [
            'khartoum' => ['name_ar' => 'ولاية الخرطوم', 'localities_count' => 7],
            'gezira' => ['name_ar' => 'ولاية الجزيرة', 'localities_count' => 8],
            'white-nile' => ['name_ar' => 'ولاية النيل الأبيض', 'localities_count' => 9],
            'blue-nile' => ['name_ar' => 'ولاية النيل الأزرق', 'localities_count' => 16],
            'northern' => ['name_ar' => 'الولاية الشمالية', 'localities_count' => 7],
            'river-nile' => ['name_ar' => 'ولاية نهر النيل', 'localities_count' => 10],
            'red-sea' => ['name_ar' => 'ولاية البحر الأحمر', 'localities_count' => 6],
            'kassala' => ['name_ar' => 'ولاية كسلا', 'localities_count' => 11],
            'gedaref' => ['name_ar' => 'ولاية القضارف', 'localities_count' => 17],
            'sennar' => ['name_ar' => 'ولاية سنار', 'localities_count' => 9],
            'north-kordofan' => ['name_ar' => 'ولاية شمال كردفان', 'localities_count' => 8],
            'south-kordofan' => ['name_ar' => 'ولاية جنوب كردفان', 'localities_count' => 20],
            'west-kordofan' => ['name_ar' => 'ولاية غرب كردفان', 'localities_count' => 7],
            'north-darfur' => ['name_ar' => 'ولاية شمال دارفور', 'localities_count' => 10],
            'south-darfur' => ['name_ar' => 'ولاية جنوب دارفور', 'localities_count' => 10],
            'central-darfur' => ['name_ar' => 'ولاية وسط دارفور', 'localities_count' => 6],
            'east-darfur' => ['name_ar' => 'ولاية شرق دارفور', 'localities_count' => 12],
            'west-darfur' => ['name_ar' => 'ولاية غرب دارفور', 'localities_count' => 10],
        ];
    }

    /** @return array<string, mixed> */
    private static function defaultPortalFields(): array
    {
        return [
            'capital' => '—',
            'cover_image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1600&q=80',
            'logo' => asset('images/state-placeholder.svg'),
            'area' => '—',
            'main_activity' => 'قيد التوثيق بالتعاون مع سفراء الولاية',
            'history_content' => '<p class="mb-4">يتم إثراء هذا القسم تدريجياً من مساهمات المجتمع وبعد المراجعة.</p><p>للوصول السريع للمحليات والخدمات استخدم التنقل أعلاه.</p>',
            'investment_summary' => '<p class="mb-4">تُحدَّث فرص الاستثمار بالولاية بعد اعتماد البيانات من الجهات المختصة.</p>',
            'investment_pdf_url' => null,
            'localities' => [],
            'landmarks' => [],
            'famous_people' => [],
            'services' => [],
            'news_items' => [],
            'events' => [],
        ];
    }

    /**
     * محتوى موسَّع لولاية نهر النيل كنموذج؛ بقية الولايات تستخدم الافتراضيات حتى الربط بقاعدة البيانات.
     *
     * @return array<string, array<string, mixed>>
     */
    private static function portalRichContent(): array
    {
        return [
            'river-nile' => [
                'capital' => 'دنقلا',
                'cover_image' => 'https://images.unsplash.com/photo-1609825488888-7a734095c812?w=1600&q=80',
                'area' => '≈ 122,000',
                'main_activity' => 'الزراعة، السياحة الأثرية، تعدين الذهب',
                'history_content' => <<<'HTML'
<p class="mb-4">تقع ولاية نهر النيل في أقصى شمال السودان وتضم تراثاً ممتداً عبر العصور من مملكة كوش ومروي إلى عهود متأخرة. يبرز فيها النيل كشريان حياة واقتصاد.</p>
<p class="mb-4">تُعدّ المنطقة مساحة غنية للآثار والدراسات التاريخية، وتشهد جهود توثيق رقمي بالتعاون مع المجتمع المحلي والسفراء.</p>
<ul class="list-disc pr-6 space-y-2 mt-4">
<li>مواقع أثرية ومجتمعات ريفية نموذجية على ضفاف النيل.</li>
<li>تنوع ثقافي يعكس تاريخاً مشتركاً بين الولاية وبقية السودان.</li>
</ul>
HTML
                ,
                'investment_summary' => <<<'HTML'
<p class="mb-4">تشمل أبرز مجالات الاستثمار المتوقعة (حسب خطة التوثيق): السياحة الأثرية، الخدمات اللوجستية المرتبطة بالزراعة، والطاقة المتجددة في المناطق ذات الإشعاع الشمسي العالي.</p>
<p>يمكنكم تحميل الخارطة الاستثمارية الموّقتة للولاية بصيغة PDF عند توفرها بعد المراجعة.</p>
HTML
                ,
                'investment_pdf_url' => null,
                'localities' => [
                    ['name' => 'دنقلا', 'maps_query' => 'Dongola Sudan administration'],
                    ['name' => 'أبو حمد', 'maps_query' => 'Abu Hamad Sudan'],
                    ['name' => 'المتمة', 'maps_query' => 'Al Matmaq Ed Damer Sudan'],
                    ['name' => 'بربر', 'maps_query' => 'Berber Sudan'],
                    ['name' => 'الدبة', 'maps_query' => 'Ed Dabba Sudan River Nile'],
                ],
                'landmarks' => [
                    [
                        'title' => 'جبل البركل',
                        'subtitle' => 'معْلم طبيعي وأثري',
                        'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=600&q=80',
                        'body' => 'من أبرز المعالم الطبيعية بالولاية ووجهة للسياحة البيئية والتوثيق الميداني.',
                    ],
                    [
                        'title' => 'إرث مملكة كوش ومروي',
                        'subtitle' => 'سياحة ثقافية',
                        'image' => 'https://images.unsplash.com/photo-1569154941061-e231b4725ef1?w=600&q=80',
                        'body' => 'منطقة غنية بالآثار؛ يُنصح بمراجعة الجولات الافتراضية 360° ضمن المنصة عند توفرها.',
                    ],
                ],
                'famous_people' => [
                    [
                        'name' => 'نموذج — عالم تراث',
                        'title' => 'باحث في التاريخ المحلي',
                        'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80',
                        'bio' => 'يُعرض هذا النموذج للتوضيح فقط؛ تُستبدل الأسماء الحقيقية بعد التحقق والمصدر.',
                    ],
                    [
                        'name' => 'نموذج — فنان شعبي',
                        'title' => 'تراث وفنون',
                        'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&q=80',
                        'bio' => 'مساحة لتوثيق الأعلام المعتمدين من فريق السفراء.',
                    ],
                ],
                'services' => [
                    ['name' => 'شرطة الطوارئ', 'locality_name' => 'دنقلا', 'phone' => '999'],
                    ['name' => 'مستشفى دنقلا التعليمي', 'locality_name' => 'دنقلا', 'phone' => '+249185123000'],
                    ['name' => 'محلية أبو حمد — الإدارة', 'locality_name' => 'أبو حمد', 'phone' => '+249261000000'],
                ],
                'news_items' => [
                    [
                        'title' => 'ورشة توثيق تراثي في دنقلا',
                        'excerpt' => 'فعالية مجتمعية لمسح التراث اللامادي بالتعاون مع شباب المحلية وسفراء المنصة.',
                        'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&q=80',
                        'published_at' => '2026-05-02',
                        'source' => 'منصة السودان الرقمي',
                    ],
                    [
                        'title' => 'تحديثات دليل الخدمات في المحليات الشمالية',
                        'excerpt' => 'إضافة أرقام الطوارئ ومكاتب الإدارة بعد المراجعة مع الإدارة المحلية.',
                        'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&q=80',
                        'published_at' => '2026-04-18',
                        'source' => 'فريق السفراء',
                    ],
                    [
                        'title' => 'سياحة أثرية: زيارة ميدانية لمؤسسات السياحة',
                        'excerpt' => 'جولة تعريفية بمسارات الزيارة المقترحة وربطها بالجولات الافتراضية داخل المنصة.',
                        'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80',
                        'published_at' => '2026-04-05',
                        'source' => 'تنسيق ولاية نهر النيل',
                    ],
                ],
                'events' => [
                    [
                        'title' => 'ملتقى التراث والموسيقى النوبية',
                        'date' => '2026-06-10',
                        'time' => '17:00',
                        'location' => 'دنقلا — المركز الثقافي',
                        'type' => 'ثقافية',
                    ],
                    [
                        'title' => 'يوم مفتوح للاستثمار الزراعي',
                        'date' => '2026-06-22',
                        'time' => '09:30',
                        'location' => 'أبو حمد',
                        'type' => 'اقتصادية',
                    ],
                    [
                        'title' => 'ماراثون شباب الولاية',
                        'date' => '2026-07-01',
                        'time' => '06:00',
                        'location' => 'الدبة',
                        'type' => 'رياضية',
                    ],
                    [
                        'title' => 'ندوة: التوثيق الرقمي للمعالم',
                        'date' => '2026-07-15',
                        'time' => '14:00',
                        'location' => 'عن بُعد (بث مباشر)',
                        'type' => 'ثقافية',
                    ],
                ],
            ],
        ];
    }
}
