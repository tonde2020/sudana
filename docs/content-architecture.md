# معمارية المحتوى والبيانات

هذه الوثيقة تترجم الرؤية المنتجية إلى بنية بيانات ومحتوى قابلة للتنفيذ داخل مشروع Laravel الحالي.

## المبادئ العامة

- لا نستخدم `Entry` لكل شيء.
- المحتوى العام يبقى في `Entry`.
- المحتوى المتخصص الذي له سلوك مختلف يحصل على نموذج مستقل.
- كل كيان عام مهم يجب أن يدعم العربية والإنجليزية والفرنسية.
- كل محتوى قابل للنشر يجب أن يحمل بيانات مصدر ومراجعة وحالة نشر.

## النماذج الحالية

- `State`
- `Locality`
- `Entry`
- `Service`
- `Contribution`
- `VirtualTour`
- `User`
- `Category`

## النماذج الجديدة المقترحة

### `InvestmentOpportunity`

يمثل فرصة استثمارية قابلة للعرض في البوابة العامة.

#### حقول أساسية

- `state_id`
- `locality_id`
- `sector_id` أو `category_id`
- `office_id`
- `title_ar`
- `title_en`
- `title_fr`
- `summary_ar`
- `summary_en`
- `summary_fr`
- `description_ar`
- `description_en`
- `description_fr`
- `investment_type`
- `readiness_status`
- `capital_range`
- `expected_roi_notes`
- `infrastructure_notes_ar`
- `infrastructure_notes_en`
- `infrastructure_notes_fr`
- `incentives_ar`
- `incentives_en`
- `incentives_fr`
- `risks_ar`
- `risks_en`
- `risks_fr`
- `latitude`
- `longitude`
- `contact_name`
- `contact_email`
- `contact_phone`
- `contact_whatsapp`
- `attachment_path`
- `image_path`
- `status`
- `is_featured`
- `published_at`
- `source_name`
- `source_url`
- `verified_at`
- `verified_by`

### `InvestmentOffice`

يمثل وزارة أو إدارة أو مكتباً مسؤولاً عن الاستثمار.

#### حقول أساسية

- `state_id`
- `name_ar`
- `name_en`
- `name_fr`
- `description_ar`
- `description_en`
- `description_fr`
- `contact_name`
- `email`
- `phone`
- `whatsapp`
- `address_ar`
- `address_en`
- `address_fr`
- `website_url`
- `working_hours`
- `is_active`

### `Story`

يمثل قصة أو نادرة أو أحجية أو مثل أو مادة سردية محلية.

#### حقول أساسية

- `state_id`
- `locality_id`
- `story_person_id`
- `story_type`
- `title_ar`
- `title_en`
- `title_fr`
- `summary_ar`
- `summary_en`
- `summary_fr`
- `content_ar`
- `content_en`
- `content_fr`
- `interpretation_ar`
- `interpretation_en`
- `interpretation_fr`
- `narrator_name`
- `source_name`
- `source_url`
- `audio_path`
- `image_path`
- `audience_age_group`
- `status`
- `is_featured`
- `published_at`
- `verified_at`
- `verified_by`

### `StoryPerson`

يمثل شخصية محلية مرتبطة بقصص أو سيرة أو أثر مجتمعي.

#### حقول أساسية

- `state_id`
- `locality_id`
- `name_ar`
- `name_en`
- `name_fr`
- `headline_ar`
- `headline_en`
- `headline_fr`
- `bio_ar`
- `bio_en`
- `bio_fr`
- `image_path`
- `birth_year`
- `death_year`
- `source_name`
- `source_url`
- `status`
- `is_featured`

### `ContentSource`

اختياري في المرحلة الأولى، لكنه مفيد إذا أردنا توحيد إدارة المصادر.

#### حقول أساسية

- `name`
- `type`
- `contact_name`
- `contact_email`
- `website_url`
- `notes`

## تطوير المساهمات

بدلاً من جعل `Contribution` خاصاً بالمحتوى العام فقط، يمكن تطويره في واحد من اتجاهين:

### الخيار السريع

الإبقاء على `Contribution` الحالي مع إضافة:

- `submission_type`
- `payload`
- `target_model`
- `target_id`

بحيث نستقبل عبره:

- مساهمة خدمة
- مساهمة فرصة استثمار
- مساهمة قصة أو أحجية
- بلاغ تصحيح

### الخيار الأنظف

إنشاء جداول متخصصة مثل:

- `investment_submissions`
- `story_submissions`
- `service_reports`

الاختيار الموصى به في هذه المرحلة هو `الخيار السريع` حتى ننطلق أسرع.

## التعدد اللغوي في البيانات

### قاعدة مهمة

الحقول التالية يجب أن تدعم 3 لغات كلما كانت ظاهرة في الواجهة العامة:

- العنوان
- الملخص
- النص الكامل
- الوصف
- العنوان الفرعي
- الحوافز
- المخاطر
- التفسير

### بديل تقني

هناك خياران:

- حقول منفصلة مثل `title_ar`, `title_en`, `title_fr`
- أو JSON مترجم مثل `title` يحتوي مفاتيح اللغات

التوصية الحالية:

- استخدام الحقول المنفصلة في هذه المرحلة.

السبب:

- أوضح داخل `Filament`
- أسهل في الفلاتر والبحث
- أبسط للفريق في الإدارة اليدوية

## المسارات العامة المقترحة

### الاستثمار

- `/investment`
- `/investment/opportunities`
- `/investment/opportunities/{slug}`
- `/investment/sectors/{slug}`
- `/investment/offices`

### الحكايات والهوية

- `/stories`
- `/stories/{slug}`
- `/stories/type/{type}`
- `/people`
- `/people/{slug}`

### اللغة

يفضل أن تصبح الروابط لاحقاً تحت بادئة لغة مثل:

- `/ar/...`
- `/en/...`
- `/fr/...`

أو عبر `SetLocale` middleware مع الحفاظ على قابلية توليد الروابط بسهولة.

## موارد Filament المقترحة

- `InvestmentOpportunityResource`
- `InvestmentOfficeResource`
- `StoryResource`
- `StoryPersonResource`

وفي حال تطوير المساهمات:

- تطوير `ContributionResource` لدعم أنواع الإرسال المختلفة.

## الصفحات العامة المقترحة

### صفحات الاستثمار

- صفحة هبوط رئيسية للاستثمار.
- صفحة قائمة فرص مع فلاتر.
- صفحة تفاصيل فرصة.
- صفحة مكاتب وجهات الاستثمار.
- صفحة إرسال فرصة أو تحديثها.

### صفحات الحكايات

- صفحة هبوط لبوابة الحكايات.
- قائمة حسب النوع أو المنطقة.
- صفحة تفاصيل قصة.
- صفحة تفاصيل شخصية.
- صفحة إرسال قصة أو أحجية.

## حالات النشر والمراجعة

يفضل توحيد الحالات عبر الكيانات الجديدة:

- `draft`
- `pending_review`
- `published`
- `rejected`
- `archived`

ولكل سجل منشور يفضل وجود:

- `verified_at`
- `verified_by`
- `review_notes`

## ترتيب التنفيذ البرمجي

1. إضافة وثائق واعتماد أسماء الكيانات.
2. إنشاء migrations للنماذج الجديدة.
3. إنشاء Eloquent models والعلاقات.
4. إنشاء Filament resources.
5. إنشاء routes/controllers/views للبوابات العامة.
6. توسيع نماذج المساهمة والمراجعة.
7. إضافة التعدد اللغوي للواجهة.
8. إضافة التعدد اللغوي للمحتوى.

## ملاحظات تصميمية

- بوابة الاستثمار يجب أن تكون عملية ورسمية وواضحة.
- بوابة الحكايات يجب أن تكون إنسانية وخفيفة وسردية.
- دليل الخدمات يجب أن يركز على الثقة والسرعة.
- لا نخلط أنواع المحتوى المختلفة داخل شاشة إدارة واحدة بلا حاجة.

## قرار تنفيذي موصى به

للمرحلة القادمة مباشرة:

- اعتماد `InvestmentOpportunity` كموديل مستقل.
- اعتماد `Story` كموديل مستقل.
- إبقاء `Entry` للمحتوى العام والتحريري.
- توسيع `Contribution` بدلاً من استبداله فوراً.
