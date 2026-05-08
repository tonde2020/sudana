<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $locality->name_ar }} - {{ config('app.name', 'السودان الرقمي') }}</title>
        <meta name="description" content="دليل محلية {{ $locality->name_ar }} داخل {{ $locality->state_name_ar }}.">

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
        <header class="border-b border-gray-100 bg-white" dir="rtl">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4 sm:py-2 lg:px-8">
                <div class="flex min-w-0 flex-1 flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ route('home') }}" class="shrink-0 font-black text-green-800 transition hover:text-green-900">السودان الرقمي</a>
                    <nav class="min-w-0 overflow-x-auto [-webkit-overflow-scrolling:touch]" aria-label="روابط الموقع">
                        <ul class="flex flex-wrap items-center gap-x-4 gap-y-2 whitespace-nowrap text-sm font-black text-gray-600 sm:gap-5">
                            <li><a href="{{ route('home') }}" class="transition hover:text-green-700">الرئيسية</a></li>
                            <li><a href="{{ route('states.show', $locality->state_slug) }}" class="transition hover:text-green-700">{{ $locality->state_name_ar }}</a></li>
                            <li><a href="{{ route('map') }}" class="transition hover:text-green-700">الخريطة</a></li>
                        </ul>
                    </nav>
                </div>
                <nav class="shrink-0 text-sm text-gray-600" aria-label="مسار التنقل">
                    <ol class="flex flex-wrap items-center gap-2 sm:justify-end">
                        <li><a href="{{ route('home') }}" class="hover:text-green-700">الرئيسية</a></li>
                        <li aria-hidden="true" class="text-gray-300">/</li>
                        <li><a href="{{ route('states.show', $locality->state_slug) }}" class="hover:text-green-700">{{ $locality->state_name_ar }}</a></li>
                        <li aria-hidden="true" class="text-gray-300">/</li>
                        <li class="font-bold text-gray-900" aria-current="page">{{ $locality->name_ar }}</li>
                    </ol>
                </nav>
            </div>
        </header>

        <main id="main-content">
            <section class="bg-gradient-to-b from-green-50 to-white py-14" dir="rtl">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-[1.35fr_0.65fr] lg:items-start">
                        <div>
                            <p class="text-sm font-black text-green-700">{{ $locality->state_name_ar }}</p>
                            <h1 class="mt-3 text-4xl font-black text-gray-900 sm:text-5xl">{{ $locality->name_ar }}</h1>
                            @if (! empty($locality->name_en))
                                <p class="mt-2 text-sm font-bold uppercase tracking-[0.2em] text-gray-400">{{ $locality->name_en }}</p>
                            @endif
                            <p class="mt-5 max-w-3xl text-lg leading-8 text-gray-600">{{ $locality->summary }}</p>

                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($locality->map_query) }}" target="_blank" rel="noopener noreferrer" class="rounded-2xl bg-green-700 px-5 py-3 text-sm font-black text-white transition hover:bg-green-800">موقع المحلية على الخرائط</a>
                                <a href="{{ route('states.show', $locality->state_slug) }}" class="rounded-2xl border border-green-200 bg-white px-5 py-3 text-sm font-black text-green-800 transition hover:bg-green-50">العودة إلى صفحة الولاية</a>
                            </div>
                        </div>

                        <aside class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                            <h2 class="text-lg font-black text-gray-900">معلومات سريعة</h2>
                            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                                <div class="rounded-2xl bg-gray-50 px-4 py-4">
                                    <p class="text-xs font-bold text-gray-400">تقدير السكان</p>
                                    <p class="mt-2 text-lg font-black text-gray-900">{{ filled($locality->population_estimate) ? number_format((float) $locality->population_estimate) : 'قيد التوثيق' }}</p>
                                </div>
                                <div class="rounded-2xl bg-gray-50 px-4 py-4">
                                    <p class="text-xs font-bold text-gray-400">المساحة</p>
                                    <p class="mt-2 text-lg font-black text-gray-900">{{ filled($locality->area_km2) ? number_format((float) $locality->area_km2) . ' كم²' : 'قيد التوثيق' }}</p>
                                </div>
                                <div class="rounded-2xl bg-gray-50 px-4 py-4">
                                    <p class="text-xs font-bold text-gray-400">عدد الخدمات الموثقة</p>
                                    <p class="mt-2 text-lg font-black text-gray-900">{{ count($locality->services) }}</p>
                                </div>
                                <div class="rounded-2xl bg-gray-50 px-4 py-4">
                                    <p class="text-xs font-bold text-gray-400">الجولات الافتراضية</p>
                                    <p class="mt-2 text-lg font-black text-gray-900">{{ count($locality->virtual_tours) }}</p>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </section>

            <section class="bg-white py-12" dir="rtl">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-none space-y-4 text-lg leading-relaxed text-gray-700 [&_ul]:pr-6 [&_ul]:marker:text-green-600">
                        {!! $locality->description !!}
                    </div>
                </div>
            </section>

            @if (count($locality->history_blocks) > 0)
                <section class="bg-gray-50 py-12" dir="rtl">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <h2 class="mb-8 text-2xl font-black text-gray-900">التاريخ المحلي والسرد التعريفي</h2>
                        <div class="grid grid-cols-1 gap-6">
                            @foreach ($locality->history_blocks as $block)
                                <article class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                        <h3 class="text-xl font-black text-gray-900">{{ $block['title'] }}</h3>
                                        <a href="{{ $block['entry_url'] }}" class="shrink-0 rounded-xl bg-green-50 px-4 py-2 text-sm font-black text-green-800 ring-1 ring-green-200 transition hover:bg-green-100">
                                            الصفحة الكاملة
                                        </a>
                                    </div>
                                    <div class="mt-4 max-w-none space-y-4 text-base leading-8 text-gray-700 [&_ul]:pr-6 [&_ul]:marker:text-green-600">
                                        {!! $block['content'] !!}
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            @if (count($locality->virtual_tours) > 0)
                <section class="bg-gray-50 py-12" dir="rtl">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <h2 class="mb-8 text-2xl font-black text-gray-900">الجولات الافتراضية</h2>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            @foreach ($locality->virtual_tours as $tour)
                                <a @if(! empty($tour['tour_url'])) href="{{ $tour['tour_url'] }}" @endif class="group overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                                    <div class="relative h-64 overflow-hidden">
                                        <img src="{{ $tour['image'] }}" alt="{{ $tour['title'] }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
                                        <div class="absolute bottom-5 right-5 left-5">
                                            <span class="mb-2 inline-block rounded-full bg-red-600 px-3 py-1 text-xs font-black text-white">360° VR</span>
                                            <h3 class="text-2xl font-black text-white">{{ $tour['title'] }}</h3>
                                            <p class="mt-1 text-sm text-white/80">{{ $tour['excerpt'] }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            @if (count($locality->landmarks) > 0)
                <section class="bg-white py-12" dir="rtl">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <h2 class="mb-8 text-2xl font-black text-gray-900">المعالم</h2>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            @foreach ($locality->landmarks as $landmark)
                                <a href="{{ $landmark['entry_url'] }}" class="group overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                                    <div class="flex flex-col sm:flex-row">
                                        <img src="{{ $landmark['image'] }}" alt="{{ $landmark['title'] }}" class="h-44 w-full object-cover sm:h-auto sm:w-48">
                                        <div class="flex-1 p-5">
                                            @if ($landmark['has_panorama'])
                                                <span class="mb-2 inline-block rounded-full bg-emerald-600 px-2.5 py-1 text-[10px] font-black text-white">360°</span>
                                            @endif
                                            <h3 class="text-xl font-black text-gray-900">{{ $landmark['title'] }}</h3>
                                            <p class="mt-2 text-sm text-gray-500">{{ $landmark['subtitle'] }}</p>
                                            <p class="mt-4 text-sm leading-7 text-gray-600">{{ $landmark['body'] }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            @if (count($locality->people) > 0)
                <section class="bg-gray-50 py-12" dir="rtl">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <h2 class="mb-8 text-2xl font-black text-gray-900">الشخصيات</h2>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
                            @foreach ($locality->people as $person)
                                <a href="{{ $person['entry_url'] }}" class="rounded-3xl border border-gray-200 bg-white p-5 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                                    <img src="{{ $person['image'] }}" alt="{{ $person['name'] }}" class="mx-auto h-24 w-24 rounded-full object-cover">
                                    <h3 class="mt-4 text-lg font-black text-gray-900">{{ $person['name'] }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $person['title'] }}</p>
                                    <p class="mt-4 text-sm leading-7 text-gray-600">{{ $person['bio'] }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            @if (count($locality->investment_entries) > 0)
                <section class="bg-white py-12" dir="rtl">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <h2 class="mb-8 text-2xl font-black text-gray-900">فرص الاستثمار</h2>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            @foreach ($locality->investment_entries as $investment)
                                <a href="{{ $investment['entry_url'] }}" class="rounded-3xl border border-gray-200 bg-gray-50 p-6 shadow-sm transition hover:-translate-y-0.5 hover:bg-white hover:shadow-md">
                                    <h3 class="text-xl font-black text-gray-900">{{ $investment['title'] }}</h3>
                                    <p class="mt-3 text-sm leading-7 text-gray-600">{{ $investment['excerpt'] }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            <section class="bg-white py-12" dir="rtl">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 class="mb-8 text-2xl font-black text-gray-900">الخدمات والجمعيات</h2>
                    @if (count($locality->services) > 0)
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                            @foreach ($locality->services as $service)
                                <article class="rounded-3xl border border-gray-200 bg-gray-50 p-6 shadow-sm">
                                    <h3 class="text-lg font-black text-gray-900">{{ $service['name'] }}</h3>
                                    @if (! empty($service['type']))
                                        <p class="mt-1 text-xs font-black text-green-700">{{ $service['type'] }}</p>
                                    @endif
                                    @if (! empty($service['description']))
                                        <p class="mt-4 text-sm leading-7 text-gray-600">{{ $service['description'] }}</p>
                                    @endif
                                    <div class="mt-4 space-y-2 text-sm">
                                        <p><span class="font-black text-gray-900">الهاتف:</span> <a href="tel:{{ preg_replace('/\s+/', '', $service['phone']) }}" class="text-green-700 hover:underline">{{ $service['phone'] }}</a></p>
                                        @if (! empty($service['address']))
                                            <p><span class="font-black text-gray-900">العنوان:</span> <span class="text-gray-600">{{ $service['address'] }}</span></p>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-3xl border border-dashed border-gray-200 bg-gray-50 p-10 text-center text-gray-500">
                            لا توجد خدمات موثقة لهذه المحلية حتى الآن.
                        </div>
                    @endif
                </div>
            </section>
        </main>
    </body>
</html>
