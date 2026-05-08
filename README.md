"دليل السودان الرقمي" كفكرة وطنية تقنية، وبطريقة تجذب انتباه أي جهة رسمية أو مطور يرغب في المساهمة.

🇸🇩 دليل السودان الرقمي | Sudan Digital Guide
🌟 الرؤية | Vision
دليل السودان الرقمي هو مبادرة وطنية تهدف إلى بناء أكبر مرجع رقمي تفاعلي للولايات السودانية. يهدف المشروع إلى توثيق التاريخ، المعالم السياحية، فرص الاستثمار، ودليل الخدمات الحيوية، ليقدم تجربة بصرية فريدة عبر تقنيات الجولات الافتراضية 360 درجة.

Sudan Digital Guide is a national initiative to build the largest interactive digital reference for Sudanese states. The project documents history, landmarks, investment opportunities, and vital services, offering a unique visual experience through 360° virtual tours.

✨ الميزات الرئيسية | Key Features
🗺️ خريطة تفاعلية (Interactive Map): استكشاف الولايات السودانية عبر واجهة رسومية ذكية.

📸 جولات افتراضية (360° Tours): تجربة بصرية غامرة للمعالم التاريخية باستخدام Pannellum.js.

🤝 نظام السفراء (Ambassadors System): مساحة مخصصة لأبناء الولايات لإضافة وتوثيق البيانات تحت إشراف إداري.

💼 بوابة الاستثمار (Investment Portal): عرض الفرص الاقتصادية والموارد الطبيعية في كل محلية.

📞 دليل الخدمات (Services Directory): أرقام الطوارئ والخدمات الحكومية بضغطة زر.

📰 أخبار الولايات (States News): تغطية حية لأهم الفعاليات والأخبار المحلية.

🛠️ التقنيات المستخدمة | Tech Stack
Backend: Laravel 11

Admin Panel: Filament V3

Frontend: Tailwind CSS & Alpine.js

Interactivity: Pannellum.js (for 360° Views)

Database: MySQL / PostgreSQL

🚀 التشغيل السريع | Quick Start
نسخ المشروع (Clone the Repo):

Bash
git clone https://github.com/your-username/sudan-digital-guide.git
cd sudan-digital-guide
تثبيت المكتبات (Install Dependencies):

Bash
composer install
npm install && npm run build
إعداد البيئة (Setup Environment):

Bash
cp .env.example .env
php artisan key:generate
المايجريشن والربط (Migrate & Link):

Bash
php artisan migrate --seed
php artisan storage:link
🤝 المساهمة | Contribution
هذا المشروع مفتوح لكل السودانيين. نرحب بمساهمات المطورين، المصورين، والمؤرخين.
This is an open-source project for all Sudanese. We welcome contributions from developers, photographers, and historians.

إهداء: هذا العمل مساهمة وطنية لنهضة السودان الرقمية، هدية من المواطن محمد ناصر لبلده.
Dedication: This work is a national contribution to Sudan's digital renaissance, a gift from Mohamed Nasir to his country.

📄 الترخيص | License
The Sudan Digital Guide is open-sourced software licensed under the MIT license.

💡 ملاحظة للمطور | Developer Note
تأكد من إعداد ملف الـ .env بشكل صحيح وضبط إعدادات الـ APP_URL لضمان عمل الجولات الافتراضية 360° دون مشاكل CORS.

صُنع بكل فخر للسودان 🇸🇩
