<!DOCTYPE html>
<html lang="{{ $currentLocale ?? app()->getLocale() }}" dir="{{ $currentDirection ?? 'rtl' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>عن المشروع — {{ config('app.name', 'السودان الرقمي') }}</title>
        <meta name="description" content="تعرف على رؤية السودان الرقمي: منصة وطنية تجمع الخدمة والاستثمار والهوية المحلية في واجهة واحدة.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            body { font-family: 'Cairo', ui-sans-serif, system-ui, sans-serif; }
        </style>
    </head>
    <body class="min-h-screen bg-[#fcfdfb] text-gray-900 antialiased">
        @include('partials.mobile-header')

        <header class="sticky top-0 z-40 border-b border-gray-100 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80" dir="{{ $currentDirection ?? 'rtl' }}">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-3 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="shrink-0 text-lg font-black text-gray-900 md:text-xl">السودان الرقمي</a>
                <nav class="hidden lg:flex" aria-label="روابط الصفحة">
                    <ul class="flex items-center gap-6 text-sm font-black text-gray-600">
                        <li><a href="{{ route('investment.index') }}" class="transition hover:text-green-700">الاستثمار</a></li>
                        <li><a href="{{ route('stories.index') }}" class="transition hover:text-green-700">الحكايات</a></li>
                        <li><a href="{{ route('contact') }}" class="transition hover:text-green-700">تواصل</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <section class="relative overflow-hidden bg-white py-16" dir="{{ $currentDirection ?? 'rtl' }}">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(22,163,74,0.12),_transparent_38%)]"></div>
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                        <div>
                            <p class="text-sm font-black uppercase tracking-[0.3em] text-green-700">About The Platform</p>
                            <h1 class="mt-4 text-4xl font-black text-gray-900 sm:text-5xl">مشروع وطني صغير في شكله، كبير في أثره</h1>
                            <p class="mt-6 text-lg leading-9 text-gray-600">
                                السودان الرقمي ليس صفحة عرض فقط، بل بنية معرفية تخدم الناس، تفتح نافذة استثمارية للولايات، وتحفظ الحكايات والذاكرة المحلية للأجيال القادمة.
                            </p>
                            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                                <a href="{{ route('volunteer.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-green-700 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-green-800">انضم للمساهمة</a>
                                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-2xl border border-green-200 bg-white px-6 py-3 text-sm font-black text-green-800 transition hover:bg-green-50">تواصل معنا</a>
                            </div>
                        </div>

                        <div class="grid gap-4">
                            <div class="rounded-[2rem] border border-green-100 bg-green-50 p-6 shadow-sm">
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-green-700">الرسالة</p>
                                <p class="mt-3 text-sm leading-8 text-gray-700">تقديم معلومة موثوقة وسريعة الوصول عن الولايات والخدمات والمعالم والفرص، داخل واجهة محترمة بصرياً وسهلة الاستخدام.</p>
                            </div>
                            <div class="rounded-[2rem] border border-emerald-100 bg-white p-6 shadow-sm">
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-emerald-700">الرؤية</p>
                                <p class="mt-3 text-sm leading-8 text-gray-700">أن تصبح المنصة مرجعاً رقمياً يخدم المواطن، ويعطي المستثمر صورة أوضح، ويمنح الذاكرة المحلية مكاناً يليق بها.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white py-18" dir="{{ $currentDirection ?? 'rtl' }}">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 text-center">
                        <h2 class="text-3xl font-black text-gray-900">ثلاث ركائز واضحة</h2>
                        <p class="mt-4 text-gray-600">بنية المشروع الحالية مبنية على ثلاث بوابات رئيسية حتى تكون القيمة عملية وليست شكلية.</p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-3">
                        <div class="rounded-[2rem] border border-gray-200 bg-gray-50 p-7 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-500">Service Layer</p>
                            <h3 class="mt-4 text-2xl font-black text-gray-900">الخدمات</h3>
                            <p class="mt-4 text-sm leading-8 text-gray-600">دليل خدمات ومحليات ومعالم واتصال سريع، مع قابلية التطوير لاحقاً إلى بلاغات وتحديثات وتحقق دوري.</p>
                        </div>
                        <div class="rounded-[2rem] border border-emerald-100 bg-emerald-50 p-7 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-emerald-700">Investment Layer</p>
                            <h3 class="mt-4 text-2xl font-black text-gray-900">الاستثمار</h3>
                            <p class="mt-4 text-sm leading-8 text-gray-600">صفحات تعرض القطاعات والفرص والجهات الرسمية والمزايا، مع محتوى عربي وإنجليزي وفرنسي داخل نفس السجل.</p>
                        </div>
                        <div class="rounded-[2rem] border border-amber-100 bg-amber-50 p-7 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-amber-700">Identity Layer</p>
                            <h3 class="mt-4 text-2xl font-black text-gray-900">الحكايات والهوية</h3>
                            <p class="mt-4 text-sm leading-8 text-gray-600">قصص وأحاجي وشخصيات محلية تعيد التوازن بين الخدمة اليومية والبعد الثقافي والذاكرة الشعبية.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-gray-50 py-20" dir="{{ $currentDirection ?? 'rtl' }}">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
                        <div class="rounded-[2rem] border border-gray-200 bg-white p-7 shadow-sm">
                            <p class="text-sm font-black uppercase tracking-[0.3em] text-green-700">What Makes It Useful</p>
                            <h2 class="mt-4 text-3xl font-black text-gray-900">لماذا هذه المنصة تخدم بجد؟</h2>
                            <p class="mt-5 text-sm leading-8 text-gray-600">لأنها لا تكتفي بالواجهة الجيدة، بل تربط المحتوى بالإدارة، وتربط الإدارة بالمراجعة، وتجهز البيانات لتصبح متعددة اللغات وقابلة للتوسع لاحقاً.</p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-[2rem] border border-white bg-white p-6 shadow-sm">
                                <h3 class="text-lg font-black text-gray-900">محتوى متعدد اللغات</h3>
                                <p class="mt-3 text-sm leading-7 text-gray-600">الحقول الأساسية الجديدة جاهزة للعربية والإنجليزية والفرنسية من داخل نفس المحتوى.</p>
                            </div>
                            <div class="rounded-[2rem] border border-white bg-white p-6 shadow-sm">
                                <h3 class="text-lg font-black text-gray-900">بوابات مستقلة بصرياً</h3>
                                <p class="mt-3 text-sm leading-7 text-gray-600">لكل مسار لون وإيقاع بصري يميزه، مع بقاء التجربة ضمن هوية واحدة.</p>
                            </div>
                            <div class="rounded-[2rem] border border-white bg-white p-6 shadow-sm">
                                <h3 class="text-lg font-black text-gray-900">إدارة فعلية من لوحة التحكم</h3>
                                <p class="mt-3 text-sm leading-7 text-gray-600">الفرص والحكايات والشخصيات وجهات الاستثمار جاهزة للإدخال والمراجعة من `/admin`.</p>
                            </div>
                            <div class="rounded-[2rem] border border-white bg-white p-6 shadow-sm">
                                <h3 class="text-lg font-black text-gray-900">قابلية التطوير</h3>
                                <p class="mt-3 text-sm leading-7 text-gray-600">يمكن لاحقاً إضافة التحقق، النماذج الرسمية، الإحصاءات، وواجهات API دون إعادة البناء من الصفر.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-gray-100 bg-gray-50 py-10" dir="{{ $currentDirection ?? 'rtl' }}">
            <div class="mx-auto max-w-7xl px-4 text-center text-sm text-gray-500 sm:px-6 lg:px-8">
                <p class="font-bold text-gray-700">{{ config('app.name', 'السودان الرقمي') }}</p>
                <p class="mt-2">عن المشروع — منصة تبني الذاكرة والخدمة والفرص من مكان واحد.</p>
            </div>
        </footer>
    </body>
</html>
