<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $tour->title }} - {{ config('app.name', 'السودان الرقمي') }}</title>
        <meta name="description" content="{{ $tour->excerpt ?: $tour->title }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            body { font-family: 'Cairo', ui-sans-serif, system-ui, sans-serif; }
        </style>
    </head>
    <body class="min-h-screen bg-white text-gray-900 antialiased">
        @include('partials.mobile-header')
        <header class="border-b border-gray-100 bg-white" dir="rtl">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4 sm:py-2 lg:px-8">
                <div class="flex min-w-0 flex-1 flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ route('home') }}" class="shrink-0 font-black text-green-800 transition hover:text-green-900">السودان الرقمي</a>
                    <nav class="min-w-0 overflow-x-auto [-webkit-overflow-scrolling:touch]" aria-label="روابط الموقع">
                        <ul class="flex flex-wrap items-center gap-x-4 gap-y-2 whitespace-nowrap text-sm font-black text-gray-600 sm:gap-5">
                            <li><a href="{{ route('home') }}" class="transition hover:text-green-700">الرئيسية</a></li>
                            @if ($tour->state)
                                <li><a href="{{ route('states.show', $tour->state->slug) }}" class="transition hover:text-green-700">{{ $tour->state->name_ar }}</a></li>
                            @endif
                            @if ($tour->locality && $tour->state)
                                <li><a href="{{ route('localities.show', ['stateSlug' => $tour->state->slug, 'localitySlug' => $tour->locality->slug]) }}" class="transition hover:text-green-700">{{ $tour->locality->name_ar }}</a></li>
                            @endif
                            <li><a href="#panorama" class="transition hover:text-green-700">الجولة 360°</a></li>
                        </ul>
                    </nav>
                </div>
                <nav class="shrink-0 text-sm text-gray-600" aria-label="مسار التنقل">
                    <ol class="flex flex-wrap items-center gap-2 sm:justify-end">
                        <li><a href="{{ route('home') }}" class="hover:text-green-700">الرئيسية</a></li>
                        @if ($tour->state)
                            <li aria-hidden="true" class="text-gray-300">/</li>
                            <li><a href="{{ route('states.show', $tour->state->slug) }}" class="hover:text-green-700">{{ $tour->state->name_ar }}</a></li>
                        @endif
                        <li aria-hidden="true" class="text-gray-300">/</li>
                        <li class="font-bold text-gray-900" aria-current="page">{{ $tour->title }}</li>
                    </ol>
                </nav>
            </div>
        </header>

        <div class="relative overflow-hidden bg-white">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-green-50/80 via-white to-white"></div>
            <div class="relative z-10 mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="mb-4 flex flex-wrap gap-2 text-xs font-black">
                    <span class="rounded-full bg-emerald-600 px-3 py-1 text-white">360°</span>
                    @if ($tour->state)
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">{{ $tour->state->name_ar }}</span>
                    @endif
                    @if ($tour->locality)
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">{{ $tour->locality->name_ar }}</span>
                    @endif
                    @if ($tour->entry?->category?->name_ar)
                        <span class="rounded-full bg-green-100 px-3 py-1 text-green-800">{{ $tour->entry->category->name_ar }}</span>
                    @endif
                </div>

                <h1 class="max-w-4xl text-4xl font-black tracking-tight text-gray-900 sm:text-5xl">{{ $tour->title }}</h1>

                @if ($tour->excerpt)
                    <p class="mt-5 max-w-3xl text-lg leading-relaxed text-gray-600">{{ $tour->excerpt }}</p>
                @endif
            </div>
        </div>

        <main id="main-content">
            <section id="panorama" class="scroll-mt-24 bg-gray-50 py-12" dir="rtl" aria-labelledby="panorama-heading">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 id="panorama-heading" class="mb-6 text-3xl font-black text-gray-900">استكشف الموقع بزاوية 360 درجة</h2>
                    @if ($tour->panorama_is_compatible)
                        <div class="relative h-[360px] w-full overflow-hidden rounded-[2rem] border-4 border-white shadow-2xl sm:h-[480px] lg:h-[600px]">
                            <div id="panorama-viewer" class="h-full w-full"></div>
                            <div id="pan-overlay" class="pointer-events-none absolute inset-0 flex items-center justify-center bg-black/30 transition-opacity duration-500">
                                <div class="text-center text-white">
                                    <svg class="mx-auto mb-4 h-16 w-16 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                    </svg>
                                    <p class="text-xl font-bold">اسحب أو حرّك لتدوير المشهد في جميع الاتجاهات</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="overflow-hidden rounded-[2rem] border-4 border-white bg-white shadow-2xl">
                            <img src="{{ $tour->panorama_url }}" alt="{{ $tour->title }}" class="h-auto w-full object-cover">
                            <div class="border-t border-amber-100 bg-amber-50 px-6 py-5 text-amber-950">
                                <p class="text-lg font-black">الصورة المرفوعة ليست جولة 360 متوافقة بعد</p>
                                <p class="mt-2 text-sm leading-7">
                                    تم رفع صورة عادية أو بانوراما غير مكتملة. حتى تعمل الجولة داخل المنصة يجب رفع صورة
                                    <span class="font-black">Equirectangular</span>
                                    بنسبة تقارب
                                    <span class="font-black">2:1</span>
                                    مثل
                                    <span class="font-black">4000×2000</span>.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            <section class="bg-white py-12" dir="rtl" aria-labelledby="tour-details-heading">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">
                        <div class="lg:col-span-2">
                            <h2 id="tour-details-heading" class="mb-6 text-2xl font-black text-gray-900">تفاصيل الجولة</h2>
                            <div class="rounded-3xl border border-gray-100 bg-gray-50 p-6 text-base leading-8 text-gray-700">
                                <p>{{ $tour->excerpt ?: 'جولة افتراضية منشورة ضمن منصة دليل السودان الرقمي.' }}</p>
                            </div>

                            @if ($tour->entry)
                                <div class="mt-6 rounded-3xl border border-green-100 bg-green-50 p-6">
                                    <p class="text-sm font-black text-green-800">المحتوى المرتبط بهذه الجولة</p>
                                    <h3 class="mt-2 text-2xl font-black text-gray-900">{{ $tour->entry->title }}</h3>
                                    @if ($tour->entry->excerpt)
                                        <p class="mt-3 text-sm leading-7 text-gray-600">{{ $tour->entry->excerpt }}</p>
                                    @endif
                                    <div class="mt-4">
                                        <a href="{{ route('entries.show', $tour->entry->slug) }}" class="inline-flex rounded-xl bg-green-700 px-5 py-3 text-sm font-black text-white transition hover:bg-green-800">
                                            عرض المحتوى الكامل
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <aside class="h-fit rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                            <h3 class="mb-4 text-lg font-black text-gray-900">معلومات سريعة</h3>
                            <ul class="space-y-4 text-sm">
                                <li class="flex justify-between gap-4 border-b border-gray-100 pb-3">
                                    <span class="text-gray-500">الولاية</span>
                                    <strong class="text-gray-900">{{ $tour->state?->name_ar ?? 'غير محددة' }}</strong>
                                </li>
                                <li class="flex justify-between gap-4 border-b border-gray-100 pb-3">
                                    <span class="text-gray-500">المحلية</span>
                                    <strong class="text-gray-900">{{ $tour->locality?->name_ar ?? 'على مستوى الولاية' }}</strong>
                                </li>
                                <li class="flex justify-between gap-4">
                                    <span class="text-gray-500">الحالة</span>
                                    <strong class="text-gray-900">{{ $tour->status }}</strong>
                                </li>
                            </ul>

                            <div class="mt-6 flex flex-col gap-3">
                                @if ($tour->locality && $tour->state)
                                    <a href="{{ route('localities.show', ['stateSlug' => $tour->state->slug, 'localitySlug' => $tour->locality->slug]) }}" class="rounded-xl bg-green-700 px-5 py-3 text-center text-sm font-black text-white transition hover:bg-green-800">العودة إلى صفحة المحلية</a>
                                @elseif ($tour->state)
                                    <a href="{{ route('states.show', $tour->state->slug) }}" class="rounded-xl bg-green-700 px-5 py-3 text-center text-sm font-black text-white transition hover:bg-green-800">العودة إلى صفحة الولاية</a>
                                @endif
                            </div>
                        </aside>
                    </div>
                </div>
            </section>
        </main>

        @if ($tour->panorama_is_compatible)
            <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
            <script>
                pannellum.viewer('panorama-viewer', {
                    type: 'panorama',
                    panorama: @json($tour->panorama_url),
                    autoLoad: true,
                    autoRotate: -1,
                    showControls: true,
                    compass: true,
                    title: @json($tour->title),
                    author: 'دليل السودان الرقمي',
                });

                document.getElementById('panorama-viewer').addEventListener('mousedown', function () {
                    const overlay = document.getElementById('pan-overlay');

                    if (overlay) {
                        overlay.style.opacity = '0';
                    }
                });
            </script>
        @endif
    </body>
</html>
