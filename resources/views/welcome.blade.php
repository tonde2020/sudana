<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'السودان الرقمي') }} - دليل السودان الرقمي</title>
        <meta name="description" content="بوابة واحدة لتوثيق تاريخ وثقافة وخدمات ولايات السودان.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            body { font-family: 'Cairo', ui-sans-serif, system-ui, sans-serif; }
        </style>
    </head>
    <body class="min-h-screen bg-white text-gray-900 antialiased">
        <a href="#main-content" class="fixed start-4 top-2 z-[100] -translate-y-[calc(100%+0.5rem)] rounded-lg bg-green-700 px-4 py-2 text-sm font-black text-white shadow-md transition-transform focus:translate-y-2 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-800">
            تخطي إلى المحتوى
        </a>

        <header class="sticky top-0 z-40 border-b border-gray-100 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80" dir="rtl" aria-label="رأس الموقع والتنقل">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-3 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:gap-4 lg:px-8">
                <div class="flex items-center justify-between gap-3">
                    <a href="{{ url('/') }}" class="shrink-0 text-lg font-black text-gray-900 md:text-xl">
                        السودان الرقمي
                    </a>
                    <div class="flex shrink-0 items-center gap-2 text-sm font-bold sm:gap-3 lg:hidden">
                        <a href="{{ route('contributor.login') }}" class="rounded-lg px-3 py-2 text-gray-700 transition hover:bg-gray-50">
                            دخول المساهم
                        </a>
                    </div>
                </div>

                <nav class="min-w-0 flex-1 overflow-x-auto [-webkit-overflow-scrolling:touch]" aria-label="أقسام الصفحة">
                    <ul class="flex items-center gap-4 whitespace-nowrap py-1 text-sm font-black text-gray-600 sm:gap-6 lg:justify-center">
                        <li><a href="{{ url('/') }}" class="transition hover:text-green-700">الرئيسية</a></li>
                        <li><a href="{{ route('map') }}" class="transition hover:text-green-700">الخريطة</a></li>
                        <li><a href="{{ url('/#states') }}" class="transition hover:text-green-700">الولايات</a></li>
                        <li><a href="{{ url('/#virtual-tours') }}" class="transition hover:text-green-700">جولات 360°</a></li>
                        <li><a href="{{ url('/#stats') }}" class="transition hover:text-green-700">أرقام</a></li>
                        <li><a href="{{ route('volunteer.create') }}" class="transition hover:text-green-700">المساهمة</a></li>
                        <li><a href="{{ url('/about') }}" class="transition hover:text-green-700">عن المشروع</a></li>
                    </ul>
                </nav>
                <div class="hidden shrink-0 items-center gap-2 text-sm font-bold sm:gap-3 lg:flex">
                    <a href="{{ route('contributor.login') }}" class="rounded-lg px-4 py-2 text-gray-700 transition hover:bg-gray-50">
                        دخول المساهم
                    </a>
                    <a href="{{ route('volunteer.create') }}" class="rounded-xl bg-green-700 px-4 py-2 text-white shadow-sm transition hover:bg-green-800">
                        إنشاء حساب مساهم
                    </a>
                </div>
            </div>
        </header>

        <div id="top" class="relative overflow-hidden bg-white">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-green-50/80 via-white to-white"></div>
            <div class="relative z-10 mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
                <h1 class="text-4xl font-black tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                    <span class="block">دليل السودان الرقمي</span>
                    <span class="mt-4 block text-3xl text-green-700">بوابة واحدة لتوثيق تاريخ، ثقافة، وخدمات ولاياتنا</span>
                </h1>
                <p class="mt-6 max-w-3xl text-xl text-gray-500">
                    استكشف الولايات السودانية، تعرّف على المعالم التاريخية، ابحث عن الخدمات، واكتشف فرص الاستثمار الواعدة.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('volunteer.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-green-700 px-6 py-3 text-sm font-black text-white transition hover:bg-green-800">
                        إنشاء حساب مساهم
                    </a>
                    <a href="{{ route('contributor.login') }}" class="inline-flex items-center justify-center rounded-2xl border border-green-200 bg-white px-6 py-3 text-sm font-black text-green-800 transition hover:bg-green-50">
                        دخول المساهم
                    </a>
                </div>

                <div class="mt-10 max-w-xl">
                    <form action="{{ url('/') }}" method="get" class="flex flex-col gap-0 overflow-hidden rounded-2xl border border-gray-300 bg-white shadow-sm sm:flex-row" role="search" aria-label="بحث في الدليل">
                        <label for="site-search" class="sr-only">البحث في الدليل</label>
                        <input
                            id="site-search"
                            name="q"
                            type="search"
                            value="{{ request('q') }}"
                            placeholder="ابحث عن ولاية، مدينة، أو معلم تاريخي..."
                            class="w-full flex-1 border-0 px-5 py-4 placeholder:text-gray-400 focus:ring-2 focus:ring-green-500 focus:ring-inset"
                            autocomplete="off"
                        >
                        <button type="submit" class="shrink-0 bg-green-700 px-8 py-4 font-black text-white transition hover:bg-green-800 sm:min-w-[120px]">
                            بحث
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <main id="main-content">
            <section class="bg-white py-14" dir="rtl" aria-labelledby="map-promo-heading">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="overflow-hidden rounded-[2rem] border border-emerald-100 bg-gradient-to-l from-emerald-900 via-emerald-800 to-green-700 text-white shadow-xl">
                        <div class="grid gap-8 px-6 py-8 sm:px-8 sm:py-10 lg:grid-cols-[1.15fr_0.85fr] lg:items-center lg:px-10">
                            <div>
                                <h2 id="map-promo-heading" class="text-3xl font-black sm:text-4xl">الخريطة التفاعلية أصبحت في صفحة مستقلة</h2>
                                <p class="mt-4 max-w-2xl text-sm leading-8 text-emerald-50 sm:text-base">
                                    افتح خريطة السودان الكاملة واستكشف الولايات من نقاطها المباشرة، مع عرض حالة التوثيق لكل ولاية وروابط الانتقال السريع إلى الأدلة المنشورة.
                                </p>
                                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                                    <a href="{{ route('map') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-6 py-3 text-sm font-black text-emerald-900 transition hover:bg-emerald-50">فتح الخريطة الكاملة</a>
                                    <a href="{{ route('volunteer.create') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/25 bg-white/10 px-6 py-3 text-sm font-black text-white transition hover:bg-white/15">انضم للمساهمة</a>
                                </div>
                            </div>
                            <div class="rounded-[1.75rem] bg-white/10 p-5 ring-1 ring-white/15">
                                <p class="text-sm font-black text-emerald-100">ماذا ستجد هناك؟</p>
                                <div class="mt-4 grid gap-3 text-sm leading-7 text-emerald-50">
                                    <p>نقاط تفاعلية لكل ولاية مع اسمها وحالة نشاطها داخل المنصة.</p>
                                    <p>وصول مباشر إلى صفحات الولايات الموثقة من دون تكديس المحتوى في الصفحة الرئيسية.</p>
                                    <p>واجهة أوضح للموبايل والشاشات الصغيرة مع الحفاظ على الـ RTL بشكل سليم.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="states" class="scroll-mt-20 bg-gray-50 py-16" aria-labelledby="states-heading" dir="rtl">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 text-center">
                        <h2 id="states-heading" class="text-3xl font-black text-gray-900">ولايات السودان</h2>
                        <p class="mt-4 text-gray-600">اختر الولاية للوصول إلى الدليل الكامل للخدمات والمعالم</p>
                    </div>

                    <div class="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-6">
                        @foreach ($states as $state)
                            <a href="{{ route('states.show', $state->slug) }}" class="group relative rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-green-600">
                                <div class="flex flex-col items-center text-center">
                                    <img src="{{ $state->logo_url }}" alt="" width="64" height="64" loading="lazy" decoding="async" class="mb-4 h-16 w-16 grayscale transition duration-300 group-hover:grayscale-0">
                                    <h3 class="text-lg font-black text-gray-800 transition group-hover:text-green-700">{{ $state->name_ar }}</h3>
                                    <span class="mt-2 text-xs text-gray-400">{{ $state->localities_count }} محلية</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="virtual-tours" class="scroll-mt-20 bg-white py-16" aria-labelledby="tours-heading" dir="rtl">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 id="tours-heading" class="text-3xl font-black text-gray-900">جولات افتراضية</h2>
                            <p class="mt-2 text-gray-500">عِش التجربة وكأنك هناك عبر تقنية 360 درجة</p>
                        </div>
                        <a href="{{ route('map') }}" class="font-black text-green-700 hover:underline">استكشف الولايات ←</a>
                    </div>

                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                        @forelse ($featuredTours as $tour)
                            <a href="{{ $tour['url'] }}" class="group relative block h-64 overflow-hidden rounded-3xl shadow-md transition hover:shadow-lg">
                                <img src="{{ $tour['src'] }}" alt="جولة افتراضية - {{ $tour['title'] }}" loading="lazy" decoding="async" class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                <div class="absolute bottom-6 right-6 left-6">
                                    <span class="mb-2 inline-block rounded-full bg-red-600 px-3 py-1 text-xs font-black text-white">360° VR</span>
                                    <h4 class="text-2xl font-black text-white">{{ $tour['title'] }}</h4>
                                    <span class="mt-1 block text-sm text-white/80">{{ $tour['tag'] }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="md:col-span-2 rounded-3xl border border-dashed border-gray-200 bg-gray-50 p-10 text-center text-gray-500">
                                لا توجد جولات افتراضية منشورة بعد. أضف صورة 360 إلى أحد المعالم من لوحة الإدارة لتظهر هنا.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="stats" class="scroll-mt-20 bg-green-900 py-12 text-white" aria-labelledby="stats-heading" dir="rtl">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 id="stats-heading" class="sr-only">أرقام المنصة</h2>
                    <div class="grid grid-cols-2 gap-8 text-center md:grid-cols-4">
                        <div>
                            <div class="mb-2 text-4xl font-black tracking-widest">{{ $stats['states'] }}</div>
                            <div class="text-green-200">ولاية موثقة</div>
                        </div>
                        <div>
                            <div class="mb-2 text-4xl font-black tracking-widest">{{ $stats['localities'] > 0 ? '+' . $stats['localities'] : 0 }}</div>
                            <div class="text-green-200">محلية</div>
                        </div>
                        <div>
                            <div class="mb-2 text-4xl font-black tracking-widest">{{ $stats['entries'] > 0 ? '+' . $stats['entries'] : 0 }}</div>
                            <div class="text-green-200">مادة منشورة</div>
                        </div>
                        <div>
                            <div class="mb-2 text-4xl font-black tracking-widest">{{ $stats['services'] > 0 ? '+' . $stats['services'] : 0 }}</div>
                            <div class="text-green-200">خدمة ورقم</div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="cta" class="scroll-mt-20 bg-white py-20" aria-labelledby="cta-heading" dir="rtl">
                <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                    <div class="rounded-[3rem] border border-green-100 bg-green-50 p-10 text-center shadow-sm sm:p-12">
                        <h2 id="cta-heading" class="mb-6 text-3xl font-black text-gray-900">كن سفيراً لولايتك</h2>
                        <p class="mx-auto mb-10 max-w-2xl text-lg leading-relaxed text-gray-600">
                            ساهم في بناء أكبر مرجع رقمي للسودان. إذا كنت من المهتمين بالتوثيق، التصوير، أو الخدمة المجتمعية، انضم الآن لفريق سفراء الولايات.
                        </p>
                        <div class="flex flex-col justify-center gap-4 sm:flex-row">
                            @if (Route::has('register'))
                                <a href="{{ route('volunteer.create') }}" class="rounded-xl bg-green-700 px-10 py-4 font-black text-white shadow-lg transition hover:bg-green-800">
                                    انضم للمساهمة
                                </a>
                            @else
                                <a href="{{ route('volunteer.create') }}" class="rounded-xl bg-green-700 px-10 py-4 font-black text-white shadow-lg transition hover:bg-green-800">
                                    انضم للمساهمة
                                </a>
                            @endif
                            <a href="{{ url('/about') }}" class="rounded-xl border border-green-200 bg-white px-10 py-4 font-black text-green-700 transition hover:bg-gray-50">
                                تعرّف على المشروع
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-gray-100 bg-gray-50 py-10" dir="rtl">
            <div class="mx-auto max-w-7xl px-4 text-center text-sm text-gray-500 sm:px-6 lg:px-8">
                <p class="font-bold text-gray-700">{{ config('app.name', 'السودان الرقمي') }}</p>
                <p class="mt-2">واجهة السودان الرقمية - توثيق للأجيال القادمة.</p>
            </div>
        </footer>
    </body>
</html>
