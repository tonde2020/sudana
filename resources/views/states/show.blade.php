<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $state->name_ar }} - {{ config('app.name', 'السودان الرقمي') }}</title>
        <meta name="description" content="بوابة معلومات {{ $state->name_ar }}: التاريخ، المحليات، الاستثمار، المعالم، ودليل الخدمات.">

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

        <header class="border-b border-gray-100 bg-white" dir="rtl">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4 sm:py-2 lg:px-8">
                <div class="flex min-w-0 flex-1 flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ url('/') }}" class="shrink-0 font-black text-green-800 transition hover:text-green-900">السودان الرقمي</a>
                    <nav class="min-w-0 overflow-x-auto [-webkit-overflow-scrolling:touch]" aria-label="روابط الموقع">
                        <ul class="flex flex-wrap items-center gap-x-4 gap-y-2 whitespace-nowrap text-sm font-black text-gray-600 sm:gap-5">
                            <li><a href="{{ url('/') }}" class="transition hover:text-green-700">الرئيسية</a></li>
                            <li><a href="{{ url('/#states') }}" class="transition hover:text-green-700">الولايات</a></li>
                            <li><a href="{{ route('map') }}" class="transition hover:text-green-700">الخريطة</a></li>
                            <li><a href="{{ url('/#virtual-tours') }}" class="transition hover:text-green-700">جولات 360°</a></li>
                            <li><a href="{{ url('/#stats') }}" class="transition hover:text-green-700">أرقام</a></li>
                            <li><a href="{{ route('volunteer.create') }}" class="transition hover:text-green-700">المساهمة</a></li>
                            <li><a href="{{ url('/about') }}" class="transition hover:text-green-700">عن المشروع</a></li>
                        </ul>
                    </nav>
                </div>
                <nav class="shrink-0 text-sm text-gray-600" aria-label="مسار التنقل">
                    <ol class="flex flex-wrap items-center justify-end gap-2">
                        <li><a href="{{ url('/') }}" class="hover:text-green-700">الرئيسية</a></li>
                        <li aria-hidden="true" class="text-gray-300">/</li>
                        <li class="font-bold text-gray-900" aria-current="page">{{ $state->name_ar }}</li>
                    </ol>
                </nav>
            </div>
        </header>

        <div class="relative flex min-h-[22rem] items-end bg-green-900 pb-8 pt-10 sm:h-80 sm:pb-10" role="banner" dir="rtl">
            <div class="absolute inset-0 overflow-hidden">
                <img
                    src="{{ $state->cover_image }}"
                    alt=""
                    width="1920"
                    height="640"
                    decoding="async"
                    fetchpriority="high"
                    class="h-full w-full object-cover opacity-40"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-green-900 via-green-900/60 to-transparent"></div>
            </div>

            <div class="relative mx-auto flex w-full max-w-7xl flex-col items-start gap-5 px-4 sm:px-6 md:flex-row md:items-center lg:px-8">
                <div class="rounded-2xl bg-white p-2 shadow-xl">
                    <img
                        src="{{ $state->logo }}"
                        alt="شعار {{ $state->name_ar }}"
                        width="96"
                        height="96"
                        class="h-24 w-24 object-contain"
                        loading="lazy"
                        decoding="async"
                    >
                </div>
                <div class="min-w-0 flex-1">
                    <h1 class="text-3xl font-black text-white sm:text-4xl">{{ $state->name_ar }}</h1>
                    <p class="mt-2 text-base text-green-100 sm:text-lg">عاصمة الولاية: <span class="font-bold text-white">{{ $state->capital }}</span></p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="#history" class="rounded-xl bg-white/10 px-4 py-2 text-sm font-black text-white ring-1 ring-white/30 backdrop-blur transition hover:bg-white/20">تعريف وتاريخ</a>
                        @if (count($state->virtual_tours ?? []) > 0)
                            <a href="#virtual-tours" class="rounded-xl bg-white/10 px-4 py-2 text-sm font-black text-white ring-1 ring-white/30 backdrop-blur transition hover:bg-white/20">جولات 360°</a>
                        @endif
                        <a href="#updates" class="rounded-xl bg-white/10 px-4 py-2 text-sm font-black text-white ring-1 ring-white/30 backdrop-blur transition hover:bg-white/20">أخبار وفعاليات</a>
                        <a href="#directory" class="rounded-xl bg-white/10 px-4 py-2 text-sm font-black text-white ring-1 ring-white/30 backdrop-blur transition hover:bg-white/20">دليل الخدمات</a>
                    </div>
                </div>
            </div>
        </div>

        <nav class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 shadow-sm backdrop-blur supports-[backdrop-filter]:bg-white/80" aria-label="أقسام الولاية" dir="rtl">
            <div class="mx-auto max-w-7xl overflow-x-auto px-4 sm:px-6 lg:px-8">
                <ul class="flex gap-8 whitespace-nowrap py-4 text-sm font-black text-gray-600 sm:text-base">
                    <li><a href="#history" class="border-b-2 border-green-700 pb-4 text-green-700">تعريف وتاريخ</a></li>
                    <li><a href="#localities" class="border-b-2 border-transparent pb-4 transition hover:border-green-700 hover:text-green-700">المحليات</a></li>
                    <li><a href="#updates" class="border-b-2 border-transparent pb-4 transition hover:border-green-700 hover:text-green-700">أخبار وفعاليات</a></li>
                    <li><a href="#investment" class="border-b-2 border-transparent pb-4 transition hover:border-green-700 hover:text-green-700">فرص الاستثمار</a></li>
                    <li><a href="#landmarks" class="border-b-2 border-transparent pb-4 transition hover:border-green-700 hover:text-green-700">المعالم والشخصيات</a></li>
                    <li><a href="#directory" class="border-b-2 border-transparent pb-4 transition hover:border-green-700 hover:text-green-700">دليل الخدمات</a></li>
                </ul>
            </div>
        </nav>

        <main id="main-content">
            <section id="history" class="scroll-mt-28 bg-white py-12" dir="rtl" aria-labelledby="history-heading">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
                        <div class="lg:col-span-2">
                            <h2 id="history-heading" class="mb-6 text-2xl font-black text-gray-900">عن الولاية وتاريخها</h2>
                            <div class="max-w-none space-y-4 text-lg leading-relaxed text-gray-700 [&_ul]:pr-6 [&_ul]:marker:text-green-600">
                                {!! $state->history_content !!}
                            </div>
                        </div>
                        <aside class="h-fit rounded-3xl border border-gray-100 bg-gray-50 p-6">
                            <h3 class="mb-4 text-lg font-black text-gray-900">معلومات سريعة</h3>
                            <ul class="space-y-4 text-sm">
                                <li class="flex justify-between gap-4 border-b border-gray-100 pb-3"><span class="text-gray-500">عدد المحليات</span> <strong class="text-gray-900">{{ $state->localities_count }}</strong></li>
                                <li class="flex justify-between gap-4 border-b border-gray-100 pb-3"><span class="text-gray-500">المساحة</span> <strong class="text-gray-900">{{ $state->area }} كم²</strong></li>
                                <li class="flex justify-between gap-4"><span class="text-gray-500">النشاط الأساسي</span> <strong class="max-w-[55%] text-right text-gray-900">{{ $state->main_activity }}</strong></li>
                            </ul>
                        </aside>
                    </div>
                </div>
            </section>

            <section id="localities" class="scroll-mt-28 bg-gray-50 py-12" dir="rtl" aria-labelledby="localities-heading">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 id="localities-heading" class="mb-8 text-2xl font-black text-gray-900">محليات الولاية</h2>
                    @php
                        $localities = $state->localities ?? [];
                    @endphp
                    @if (count($localities) > 0)
                        <ul class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($localities as $loc)
                                <li class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0">
                                            <h3 class="text-lg font-black text-gray-900">{{ $loc['name'] }}</h3>
                                            @if (! empty($loc['name_en']))
                                                <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-gray-400">{{ $loc['name_en'] }}</p>
                                            @endif
                                        </div>
                                        <a
                                            href="{{ $mapsSearchBase }}{{ urlencode($loc['maps_query']) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="shrink-0 rounded-xl bg-green-50 px-3 py-2 text-xs font-black text-green-800 ring-1 ring-green-200 transition hover:bg-green-100"
                                        >
                                            خرائط Google
                                        </a>
                                    </div>

                                    <p class="mt-4 text-sm leading-7 text-gray-600">{{ $loc['summary'] }}</p>

                                    <div class="mt-4 grid grid-cols-2 gap-3">
                                        <div class="rounded-xl bg-gray-50 px-4 py-3">
                                            <p class="text-xs font-bold text-gray-400">تقدير السكان</p>
                                            <p class="mt-1 text-sm font-black text-gray-900">
                                                {{ filled($loc['population_estimate']) ? number_format((float) $loc['population_estimate']) : 'قيد التوثيق' }}
                                            </p>
                                        </div>
                                        <div class="rounded-xl bg-gray-50 px-4 py-3">
                                            <p class="text-xs font-bold text-gray-400">المساحة</p>
                                            <p class="mt-1 text-sm font-black text-gray-900">
                                                {{ filled($loc['area_km2']) ? number_format((float) $loc['area_km2']) . ' كم²' : 'قيد التوثيق' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-4 flex flex-wrap gap-3">
                                        @if (! empty($loc['url']))
                                            <a href="{{ $loc['url'] }}" class="rounded-xl bg-green-700 px-4 py-2 text-xs font-black text-white transition hover:bg-green-800">
                                                تصفح المحلية
                                            </a>
                                        @endif
                                        <a
                                            href="{{ $mapsSearchBase }}{{ urlencode($loc['maps_query']) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="rounded-xl bg-green-50 px-4 py-2 text-xs font-black text-green-800 ring-1 ring-green-200 transition hover:bg-green-100"
                                        >
                                            خرائط Google
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="rounded-2xl border border-dashed border-gray-200 bg-white p-8 text-center text-gray-500">جاري توثيق قائمة المحليات وربط المواقع الإدارية على الخرائط.</p>
                    @endif
                </div>
            </section>

            @php $virtualTours = $state->virtual_tours ?? []; @endphp
            @if (count($virtualTours) > 0)
                <section id="virtual-tours" class="scroll-mt-28 bg-white py-12" dir="rtl" aria-labelledby="virtual-tours-heading">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <h2 id="virtual-tours-heading" class="text-2xl font-black text-gray-900">الجولات الافتراضية</h2>
                                <p class="mt-2 text-gray-500">معالم موثقة داخل {{ $state->name_ar }} تتوفر لها تجربة 360 درجة.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            @foreach ($virtualTours as $tour)
                                <a @if(! empty($tour['tour_url'])) href="{{ $tour['tour_url'] }}" @endif class="group overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                                    <div class="relative h-64 overflow-hidden">
                                        <img src="{{ $tour['image'] }}" alt="{{ $tour['title'] }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
                                        <div class="absolute bottom-5 right-5 left-5">
                                            <span class="mb-2 inline-block rounded-full bg-red-600 px-3 py-1 text-xs font-black text-white">360° VR</span>
                                            <h3 class="text-2xl font-black text-white">{{ $tour['title'] }}</h3>
                                            <p class="mt-1 text-sm text-white/80">{{ $tour['subtitle'] }}</p>
                                            @if (! empty($tour['locality_name']))
                                                <p class="mt-2 text-xs font-black text-white/70">المحلية: {{ $tour['locality_name'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            <section id="updates" class="scroll-mt-28 bg-white py-16" dir="rtl" aria-labelledby="updates-main-title">
                @php
                    $newsList = collect($state->news_items ?? [])->sortByDesc('published_at')->take(3)->values();
                    $eventsUpcoming = collect($state->events ?? [])
                        ->filter(function (array $e) {
                            return \Illuminate\Support\Carbon::parse($e['date'])->startOfDay()->gte(now()->startOfDay());
                        })
                        ->sortBy('date')
                        ->take(4)
                        ->values();
                @endphp
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 id="updates-main-title" class="sr-only">أخبار الولاية والفعاليات القادمة</h2>
                    @if ($newsList->isEmpty() && $eventsUpcoming->isEmpty())
                        <div class="rounded-3xl border border-dashed border-gray-200 bg-gray-50/80 p-10 text-center text-gray-500">
                            <p class="font-bold text-gray-700">الأخبار والفعاليات</p>
                            <p class="mt-2 text-sm">لا توجد أخبار أو فعاليات مدرجة لهذه الولاية حالياً. يُرجى العودة لاحقاً أو تفعيل المحتوى من لوحة الإدارة.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
                            <div class="lg:col-span-2">
                                <h3 class="mb-8 border-r-4 border-red-600 pr-4 text-2xl font-black text-gray-900">أخبار الولاية</h3>
                                @if ($newsList->isEmpty())
                                    <p class="rounded-2xl border border-gray-100 bg-gray-50 p-8 text-center text-sm text-gray-500">لا توجد أخبار محلية بعد.</p>
                                @else
                                    <div class="space-y-6">
                                        @foreach ($newsList as $news)
                                            @php
                                                $published = \Illuminate\Support\Carbon::parse($news['published_at'])->timezone(config('app.timezone'));
                                                $shareText = $news['title']."\n".url()->current().'#updates';
                                                $waUrl = 'https://wa.me/?text='.rawurlencode($shareText);
                                            @endphp
                                            <article class="overflow-hidden rounded-2xl bg-gray-50 shadow-sm transition hover:bg-gray-100">
                                                <div class="flex flex-col gap-0 md:flex-row">
                                                    <img src="{{ $news['image'] }}" alt="" loading="lazy" decoding="async" class="h-40 w-full object-cover md:h-auto md:w-48 md:min-h-[160px]">
                                                    <div class="flex flex-1 flex-col p-4">
                                                        <time class="mb-2 block text-xs font-black text-red-600" datetime="{{ $published->toIso8601String() }}">{{ $published->locale('ar')->translatedFormat('Y/m/d') }}</time>
                                                        <h3 class="mb-2 text-xl font-black text-gray-800">{{ $news['title'] }}</h3>
                                                        <p class="line-clamp-2 text-sm leading-relaxed text-gray-600">{{ $news['excerpt'] }}</p>
                                                        @if (! empty($news['source']))
                                                            <p class="mt-2 text-xs text-gray-400">المصدر: {{ $news['source'] }}</p>
                                                        @endif
                                                        <div class="mt-3 flex flex-wrap gap-2">
                                                            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 rounded-xl bg-green-600 px-3 py-1.5 text-xs font-black text-white hover:bg-green-700">
                                                                <span aria-hidden="true">↗</span> واتساب
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="lg:col-span-1">
                                <h3 class="mb-8 border-r-4 border-blue-600 pr-4 text-2xl font-black text-gray-900">فعاليات قادمة</h3>
                                <div class="space-y-6 rounded-3xl bg-blue-50 p-6">
                                    @if ($eventsUpcoming->isEmpty())
                                        <p class="py-10 text-center text-gray-400">لا توجد فعاليات مجدولة حالياً</p>
                                    @else
                                        @foreach ($eventsUpcoming as $event)
                                            @php
                                                $d = \Illuminate\Support\Carbon::parse($event['date'])->timezone(config('app.timezone'));
                                            @endphp
                                            <div class="flex items-start gap-4 border-b border-blue-100 pb-5 last:border-0 last:pb-0">
                                                <div class="min-w-[60px] rounded-xl bg-white p-3 text-center shadow-sm">
                                                    <span class="block text-xl font-black text-blue-600">{{ $d->format('d') }}</span>
                                                    <span class="block text-xs text-gray-500">{{ $d->locale('ar')->translatedFormat('M') }}</span>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    @if (! empty($event['type']))
                                                        <span class="mb-1 inline-block rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-black text-blue-800">{{ $event['type'] }}</span>
                                                    @endif
                                                    <h4 class="text-sm font-black text-gray-800">{{ $event['title'] }}</h4>
                                                    @if (! empty($event['time']))
                                                        <p class="mt-1 text-xs text-gray-500">الوقت: {{ $event['time'] }}</p>
                                                    @endif
                                                    <p class="mt-1 flex items-start gap-1 text-xs text-gray-500">
                                                        <span class="mt-0.5 shrink-0 text-blue-500" aria-hidden="true">
                                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                        </span>
                                                        <span>{{ $event['location'] }}</span>
                                                    </p>
                                                    @php $waEvent = 'https://wa.me/?text='.rawurlencode($event['title']."\n".$d->locale('ar')->translatedFormat('l j F Y')."\n".url()->current().'#updates'); @endphp
                                                    <a href="{{ $waEvent }}" class="mt-2 inline-block text-xs font-black text-blue-700 hover:underline">مشاركة عبر واتساب</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            <section id="investment" class="scroll-mt-28 bg-white py-12" dir="rtl" aria-labelledby="investment-heading">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                        <div class="max-w-3xl">
                            <h2 id="investment-heading" class="mb-6 text-2xl font-black text-gray-900">فرص الاستثمار</h2>
                            <div class="max-w-none space-y-4 text-lg leading-relaxed text-gray-700">
                                {!! $state->investment_summary !!}
                            </div>
                        </div>
                        <div class="shrink-0 lg:pt-10">
                            @if (! empty($state->investment_pdf_url))
                                <a href="{{ $state->investment_pdf_url }}" download class="inline-flex items-center justify-center rounded-2xl bg-green-700 px-6 py-4 text-center font-black text-white shadow-lg ring-2 ring-green-800/20 transition hover:bg-green-800">
                                    تحميل خارطة الاستثمار (PDF)
                                </a>
                                <p class="mt-2 max-w-xs text-xs text-gray-400">ملف مضغوط ومحسّن للتحميل عبر الشبكات المحمولة.</p>
                            @else
                                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-amber-950">
                                    <p class="text-sm font-black">خارطة الاستثمار (PDF)</p>
                                    <p class="mt-2 text-xs leading-relaxed">سيتم نشر الملف بعد المراجعة والاعتماد. يمكنكم متابعة التحديثات لاحقاً.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <section id="landmarks" class="scroll-mt-28 bg-gray-50 py-12" dir="rtl" aria-labelledby="landmarks-heading">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 id="landmarks-heading" class="mb-2 text-2xl font-black text-gray-900">المعالم والشخصيات</h2>
                    <p class="mb-10 text-gray-500">اختر بطاقة لعرض التفاصيل، ويمكنك الانتقال إلى الصفحة الكاملة لأي معلم أو شخصية موثقة.</p>

                    @php
                        $landmarks = $state->landmarks ?? [];
                        $people = $state->famous_people ?? [];
                    @endphp

                    @if (count($landmarks) > 0)
                        <h3 class="mb-6 text-xl font-black text-gray-800">معالم بارزة</h3>
                        <div class="mb-14 grid grid-cols-1 gap-6 md:grid-cols-2">
                            @foreach ($landmarks as $i => $lm)
                                <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                                    <button type="button" class="flex w-full text-right transition hover:bg-gray-50" data-open-modal="dlg-landmark-{{ $i }}">
                                        <img src="{{ $lm['image'] }}" alt="" loading="lazy" decoding="async" class="h-36 w-40 shrink-0 object-cover sm:h-44 sm:w-48">
                                        <div class="flex flex-1 flex-col justify-center p-4">
                                            @if (! empty($lm['has_panorama']))
                                                <span class="mb-2 inline-block w-fit rounded-full bg-emerald-600 px-2.5 py-1 text-[10px] font-black text-white">360°</span>
                                            @endif
                                            <h4 class="font-black text-gray-900">{{ $lm['title'] }}</h4>
                                            <p class="mt-1 text-sm text-gray-500">{{ $lm['subtitle'] }}</p>
                                            <span class="mt-3 text-sm font-black text-green-700">عرض التفاصيل</span>
                                        </div>
                                    </button>
                                </article>
                                <dialog id="dlg-landmark-{{ $i }}" class="max-w-lg rounded-2xl p-0 backdrop:bg-black/50 open:backdrop:backdrop-blur-[2px]">
                                    <div class="max-h-[85vh] overflow-y-auto p-6">
                                        <img src="{{ $lm['image'] }}" alt="" class="mb-4 h-48 w-full rounded-xl object-cover">
                                        <h3 class="text-xl font-black text-gray-900">{{ $lm['title'] }}</h3>
                                        <p class="mt-2 text-sm text-gray-500">{{ $lm['subtitle'] }}</p>
                                        <p class="mt-4 text-gray-700">{{ $lm['body'] }}</p>
                                        <div class="mt-6 flex flex-wrap gap-3">
                                            @if (! empty($lm['entry_url']))
                                                <a href="{{ $lm['entry_url'] }}" class="rounded-xl bg-green-700 px-5 py-2 text-sm font-black text-white transition hover:bg-green-800">الصفحة الكاملة</a>
                                            @endif
                                            <form method="dialog" class="flex justify-start">
                                                <button type="submit" value="close" class="rounded-xl bg-gray-100 px-5 py-2 font-black text-gray-800 hover:bg-gray-200">إغلاق</button>
                                            </form>
                                        </div>
                                    </div>
                                </dialog>
                            @endforeach
                        </div>
                    @endif

                    @if (count($people) > 0)
                        <h3 class="mb-6 text-xl font-black text-gray-800">أعلام وشخصيات من الولاية</h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                            @foreach ($people as $j => $person)
                                <div class="rounded-2xl border border-gray-100 bg-white p-4 text-center shadow-sm">
                                    <button type="button" class="group w-full" data-open-modal="dlg-person-{{ $j }}">
                                        <img src="{{ $person['image'] }}" alt="" loading="lazy" decoding="async" class="mx-auto mb-4 h-24 w-24 rounded-full object-cover ring-2 ring-transparent transition group-hover:ring-green-600">
                                        <h4 class="font-black text-gray-800">{{ $person['name'] }}</h4>
                                        <p class="mt-1 text-xs text-gray-500">{{ $person['title'] }}</p>
                                        <span class="mt-3 inline-block text-xs font-black text-green-700">عرض السيرة</span>
                                    </button>
                                </div>
                                <dialog id="dlg-person-{{ $j }}" class="max-w-lg rounded-2xl p-0 backdrop:bg-black/50 open:backdrop:backdrop-blur-[2px]">
                                    <div class="p-6">
                                        <div class="flex flex-col items-center text-center sm:flex-row sm:items-start sm:gap-4 sm:text-right">
                                            <img src="{{ $person['image'] }}" alt="" class="mb-4 h-24 w-24 shrink-0 rounded-full object-cover sm:mb-0">
                                            <div>
                                                <h3 class="text-xl font-black text-gray-900">{{ $person['name'] }}</h3>
                                                <p class="text-sm text-gray-500">{{ $person['title'] }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-4 text-sm leading-relaxed text-gray-700">{!! nl2br(e($person['bio'])) !!}</div>
                                        <div class="mt-6 flex flex-wrap gap-3">
                                            @if (! empty($person['entry_url']))
                                                <a href="{{ $person['entry_url'] }}" class="rounded-xl bg-green-700 px-5 py-2 text-sm font-black text-white transition hover:bg-green-800">الصفحة الكاملة</a>
                                            @endif
                                            <form method="dialog" class="flex justify-start">
                                                <button type="submit" class="rounded-xl bg-gray-100 px-5 py-2 font-black text-gray-800 hover:bg-gray-200">إغلاق</button>
                                            </form>
                                        </div>
                                    </div>
                                </dialog>
                            @endforeach
                        </div>
                    @endif

                    @if (count($landmarks) === 0 && count($people) === 0)
                        <p class="rounded-2xl border border-dashed border-gray-200 bg-white p-8 text-center text-gray-500">لا توجد بطاقات موثقة بعد في هذا القسم؛ ستضاف مع مساهمات السفراء والمراجعة.</p>
                    @endif
                </div>
            </section>

            <section id="directory" class="scroll-mt-28 bg-white py-12" dir="rtl" aria-labelledby="directory-heading">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 id="directory-heading" class="mb-8 text-2xl font-black text-gray-900">دليل الخدمات والطوارئ</h2>
                    @php $services = $state->services ?? []; @endphp
                    @if (count($services) > 0)
                        <div class="overflow-hidden rounded-2xl border border-gray-100 shadow-sm">
                            <div class="overflow-x-auto">
                                <table class="w-full min-w-[32rem] text-right text-sm">
                                    <thead class="bg-gray-50 font-black text-gray-900">
                                        <tr>
                                            <th scope="col" class="border-b border-gray-200 p-4">الخدمة</th>
                                            <th scope="col" class="border-b border-gray-200 p-4">الموقع/المحلية</th>
                                            <th scope="col" class="border-b border-gray-200 p-4">رقم الهاتف</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($services as $service)
                                            <tr class="transition hover:bg-gray-50">
                                                <td class="p-4 font-bold text-gray-900">{{ $service['name'] }}</td>
                                                <td class="p-4 text-gray-500">{{ $service['locality_name'] }}</td>
                                                <td class="p-4">
                                                    <a href="tel:{{ preg_replace('/\s+/', '', $service['phone']) }}" class="font-black text-green-700 hover:underline">{{ $service['phone'] }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <p class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-8 text-center text-gray-500">لم تُضف أرقام الخدمات بعد؛ يمكن للجهات المعنية تزويدنا بالبيانات بعد المراجعة.</p>
                    @endif
                </div>
            </section>
        </main>

        <footer class="border-t border-gray-100 bg-gray-50 py-8" dir="rtl">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 text-center text-sm text-gray-500 sm:flex-row sm:text-right">
                <a href="{{ url('/') }}" class="font-black text-green-800 hover:underline">العودة إلى الرئيسية</a>
                <p>© {{ config('app.name', 'السودان الرقمي') }} - {{ $state->name_ar }}</p>
            </div>
        </footer>

        <script>
            document.querySelectorAll('[data-open-modal]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var id = btn.getAttribute('data-open-modal');
                    var dlg = document.getElementById(id);

                    if (dlg && typeof dlg.showModal === 'function') {
                        dlg.showModal();
                    }
                });
            });
        </script>
    </body>
</html>
