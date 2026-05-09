<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\InvestmentOffice;
use App\Models\InvestmentOpportunity;
use App\Models\Locality;
use App\Models\State;
use App\Models\Story;
use App\Models\StoryPerson;
use App\Models\User;
use Illuminate\Database\Seeder;

class PortalExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $state = State::query()->orderBy('id')->first();

        if (! $state) {
            return;
        }

        $reviewer = User::query()->where('email', 'test@example.com')->first();
        $locality = Locality::query()->where('state_id', $state->id)->orderBy('id')->first();

        $investmentCategory = Category::query()->where('slug', 'investment-opportunities')->first()
            ?? Category::query()->where('slug', 'investment')->first();

        $office = InvestmentOffice::query()->updateOrCreate(
            ['slug' => $state->slug . '-investment-office'],
            [
                'state_id' => $state->id,
                'name_ar' => 'وزارة الاستثمار والصناعة - ' . $state->name_ar,
                'name_en' => 'Ministry of Investment and Industry - ' . ($state->name_en ?: 'State'),
                'name_fr' => "Ministere de l'investissement et de l'industrie - " . ($state->name_en ?: 'Etat'),
                'description_ar' => 'جهة ولائية معنية بعرض الفرص الاستثمارية، الترويج للمشروعات، وتنسيق التواصل مع المستثمرين.',
                'description_en' => 'A state-level office responsible for promoting investment opportunities and coordinating investor communication.',
                'description_fr' => "Bureau regional charge de promouvoir les opportunites d'investissement et de coordonner les echanges avec les investisseurs.",
                'contact_name' => 'مكتب الترويج الاستثماري',
                'email' => 'investment@example.com',
                'phone' => '+249120000000',
                'whatsapp' => '+249120000000',
                'address_ar' => 'مقر الولاية',
                'address_en' => 'State headquarters',
                'address_fr' => "Siege de l'etat",
                'website_url' => 'https://example.com/investment',
                'working_hours' => '08:00 - 15:00',
                'is_active' => true,
            ],
        );

        InvestmentOpportunity::query()->updateOrCreate(
            ['slug' => $state->slug . '-agro-processing-hub'],
            [
                'state_id' => $state->id,
                'locality_id' => $locality?->id,
                'category_id' => $investmentCategory?->id,
                'office_id' => $office->id,
                'reviewer_id' => $reviewer?->id,
                'title_ar' => 'مجمع للتعبئة والتصنيع الزراعي',
                'title_en' => 'Agro-processing and Packaging Hub',
                'title_fr' => 'Pole de transformation et de conditionnement agricole',
                'summary_ar' => 'فرصة لإنشاء مجمع يربط الإنتاج الزراعي المحلي بالتعبئة والتخزين والتسويق.',
                'summary_en' => 'An opportunity to establish a hub that links local agricultural output with packaging, storage, and market access.',
                'summary_fr' => "Une opportunite de creer un pole reliant la production agricole locale au conditionnement, au stockage et a l'acces au marche.",
                'description_ar' => '<p>تستهدف هذه الفرصة إنشاء مجمع متكامل لخدمة المنتجين المحليين عبر التعبئة، الفرز، التخزين البارد، والخدمات اللوجستية المساندة.</p>',
                'description_en' => '<p>This opportunity proposes an integrated hub offering packaging, sorting, cold storage, and supporting logistics for local producers.</p>',
                'description_fr' => "<p>Cette opportunite propose un pole integre offrant conditionnement, tri, stockage frigorifique et logistique de soutien aux producteurs locaux.</p>",
                'investment_type' => 'PPP / Direct Investment',
                'readiness_status' => 'Concept Note Ready',
                'capital_range' => 'USD 1M - 3M',
                'expected_roi_notes' => 'Phased rollout with revenue generated from aggregation, packaging, and logistics services.',
                'infrastructure_notes_ar' => 'قرب من مناطق الإنتاج والطرق الداخلية ونقطة تجميع قائمة.',
                'infrastructure_notes_en' => 'Near production areas, feeder roads, and an existing aggregation point.',
                'infrastructure_notes_fr' => "Proche des zones de production, des routes locales et d'un point de collecte existant.",
                'incentives_ar' => 'إمكانية تخصيص أرض وتسهيلات ولائية وتنسيق مع الجهات الرسمية.',
                'incentives_en' => 'Potential land allocation, state support, and facilitation with public authorities.',
                'incentives_fr' => "Possibilite d'attribution fonciere, d'appui regional et de facilitation avec les autorites.",
                'risks_ar' => 'يتطلب نجاح المشروع خطة تشغيل جيدة وسلسلة توريد مستقرة.',
                'risks_en' => 'Success depends on sound operations and a stable supply chain.',
                'risks_fr' => "La reussite depend d'une bonne exploitation et d'une chaine d'approvisionnement stable.",
                'contact_name' => 'وحدة الفرص الاستثمارية',
                'contact_email' => 'opportunities@example.com',
                'contact_phone' => '+249122222222',
                'contact_whatsapp' => '+249122222222',
                'status' => InvestmentOpportunity::STATUS_PUBLISHED,
                'is_featured' => true,
                'published_at' => now(),
                'source_name' => 'Portal Demo Seeder',
                'source_url' => 'https://example.com/opportunity-note',
                'verified_at' => now(),
                'review_notes' => 'بيانات أولية لغرض عرض تجربة البوابة الجديدة.',
            ],
        );

        $person = StoryPerson::query()->updateOrCreate(
            ['slug' => $state->slug . '-community-memory-keeper'],
            [
                'state_id' => $state->id,
                'locality_id' => $locality?->id,
                'reviewer_id' => $reviewer?->id,
                'name_ar' => 'راوي من ذاكرة المنطقة',
                'name_en' => 'Keeper of Local Memory',
                'name_fr' => 'Gardien de la memoire locale',
                'headline_ar' => 'شخصية رمزية تمثل الرواة المحليين وحفظ السرد الشعبي.',
                'headline_en' => 'A symbolic figure representing local storytellers and memory keepers.',
                'headline_fr' => "Une figure symbolique representant les conteurs locaux et les gardiens de la memoire.",
                'bio_ar' => '<p>يمثل هذا الملف مساحة مبدئية لتوثيق الشخصيات التي تحفظ القصص والأمثال والنوادر داخل المجتمع المحلي.</p>',
                'bio_en' => '<p>This profile acts as a starting point for documenting figures who preserve stories, proverbs, and oral memory.</p>',
                'bio_fr' => "<p>Ce profil sert de point de depart pour documenter les figures qui preservent les recits, proverbes et la memoire orale.</p>",
                'status' => StoryPerson::STATUS_PUBLISHED,
                'is_featured' => true,
                'published_at' => now(),
                'verified_at' => now(),
                'source_name' => 'Portal Demo Seeder',
                'source_url' => 'https://example.com/story-source',
                'review_notes' => 'شخصية تمهيدية لتجربة البوابة السردية.',
            ],
        );

        Story::query()->updateOrCreate(
            ['slug' => $state->slug . '-moonlight-riddle'],
            [
                'state_id' => $state->id,
                'locality_id' => $locality?->id,
                'story_person_id' => $person->id,
                'reviewer_id' => $reviewer?->id,
                'story_type' => Story::TYPE_RIDDLE,
                'title_ar' => 'أحجية من ليالي المنطقة',
                'title_en' => 'A Riddle from the Region',
                'title_fr' => 'Une enigme de la region',
                'summary_ar' => 'مادة تجريبية توضح كيف يمكن للمنصة حفظ الأحاجي والشرح المرتبط بها.',
                'summary_en' => 'A demo piece showing how the platform can preserve riddles and their explanations.',
                'summary_fr' => "Un contenu de demonstration montrant comment la plateforme peut conserver les enigmes et leurs explications.",
                'content_ar' => '<p>ما الشيء الذي يسير معك في الشمس ويختفي في الظلام؟</p>',
                'content_en' => '<p>What walks with you in sunlight and disappears in the dark?</p>',
                'content_fr' => "<p>Qu'est-ce qui marche avec toi au soleil et disparait dans l'obscurite ?</p>",
                'interpretation_ar' => 'الجواب: الظل. ويمكن استخدام هذا القسم لشرح المعنى والسياق الثقافي وطريقة تداول الأحجية.',
                'interpretation_en' => 'Answer: the shadow. This field can explain meaning, context, and how the riddle circulates locally.',
                'interpretation_fr' => "Reponse : l'ombre. Ce champ peut expliquer le sens, le contexte et la circulation locale de l'enigme.",
                'narrator_name' => 'رواية مجتمعية',
                'source_name' => 'Portal Demo Seeder',
                'source_url' => 'https://example.com/riddle-source',
                'audience_age_group' => 'All Ages',
                'status' => Story::STATUS_PUBLISHED,
                'is_featured' => true,
                'published_at' => now(),
                'verified_at' => now(),
                'review_notes' => 'مادة تمهيدية لاختبار تجربة الأحاجي داخل المنصة.',
            ],
        );
    }
}
