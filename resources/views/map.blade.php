<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>خريطة السودان التفاعلية - {{ config('app.name', 'السودان الرقمي') }}</title>
        <meta name="description" content="خريطة السودان التفاعلية للوصول إلى دليل الولايات والمحتوى الموثق والخدمات.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            body { font-family: 'Cairo', ui-sans-serif, system-ui, sans-serif; }
        </style>
    </head>
    <body class="min-h-screen bg-[#f7fbf7] text-gray-900 antialiased">
        @include('partials.mobile-header')
        <header class="sticky top-0 z-40 border-b border-emerald-100 bg-white/90 backdrop-blur" dir="rtl">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-3 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                <div class="flex items-center justify-between gap-3">
                    <a href="{{ route('home') }}" class="text-lg font-black text-emerald-900">السودان الرقمي</a>
                    <a href="{{ route('volunteer.create') }}" class="rounded-xl bg-emerald-700 px-4 py-2 text-sm font-black text-white transition hover:bg-emerald-800 lg:hidden">انضم للمساهمة</a>
                </div>
                <nav class="overflow-x-auto [-webkit-overflow-scrolling:touch]" aria-label="التنقل">
                    <ul class="flex items-center gap-5 whitespace-nowrap text-sm font-black text-gray-600">
                        <li><a href="{{ route('home') }}" class="transition hover:text-emerald-700">الرئيسية</a></li>
                        <li><a href="{{ route('map') }}" class="text-emerald-700">الخريطة</a></li>
                        <li><a href="{{ route('home') }}#states" class="transition hover:text-emerald-700">الولايات</a></li>
                        <li><a href="{{ route('volunteer.create') }}" class="transition hover:text-emerald-700">المساهمة</a></li>
                    </ul>
                </nav>
                <a href="{{ route('volunteer.create') }}" class="hidden rounded-xl bg-emerald-700 px-5 py-2.5 text-sm font-black text-white transition hover:bg-emerald-800 lg:inline-flex">انضم للمساهمة</a>
            </div>
        </header>

        <main>
            <section class="px-4 py-10 sm:px-6 lg:px-8 lg:py-14" dir="rtl">
                <div class="mx-auto max-w-7xl">
                    <div class="mb-8 text-center">
                        <span class="inline-flex rounded-full bg-emerald-100 px-4 py-2 text-xs font-black text-emerald-800">خريطة السودان التفاعلية</span>
                        <h1 class="mt-5 text-4xl font-black tracking-tight text-gray-900 sm:text-5xl">استكشف الولايات من الخريطة مباشرة</h1>
                        <p class="mx-auto mt-4 max-w-3xl text-base leading-8 text-gray-600 sm:text-lg">
                            كل نقطة تقود إلى صفحة الولاية عند توفر البيانات. الألوان تعكس حالة التوثيق والنشاط داخل المنصة.
                        </p>
                    </div>

                    <div class="rounded-[2rem] border border-emerald-100 bg-white p-4 shadow-sm sm:p-6">
                        <div class="mb-6 flex flex-wrap items-center justify-center gap-4 text-sm font-bold text-gray-600">
                            <span class="inline-flex items-center gap-2">
                                <span class="h-3 w-3 rounded-full bg-emerald-700"></span>
                                ولاية نشطة أو مكتملة
                            </span>
                            <span class="inline-flex items-center gap-2">
                                <span class="h-3 w-3 rounded-full bg-emerald-200 ring-1 ring-emerald-400"></span>
                                قيد التوثيق
                            </span>
                        </div>

                        <div class="overflow-x-auto rounded-[2rem] bg-[#fbfefb] p-3 ring-1 ring-emerald-100 sm:p-5">
                            <svg viewBox="0 0 760 760" class="h-auto min-w-[760px] w-full">
                                <g transform="translate(120 0)">
                                    <path
                                        d="M246 24c31 14 61 42 78 78 13 28 38 42 78 63 26 14 44 35 54 63 14 38 10 75-11 111-11 18-11 33-4 57 16 52 13 88-10 120-15 22-24 44-25 67-2 48-17 87-47 118-23 24-48 42-76 55-33 16-68 24-103 24-45 0-87-12-123-35-39-24-67-56-84-99-14-35-16-71-8-108 5-23 1-44-11-65-26-43-34-88-21-136 7-28 21-52 42-74 20-20 32-41 37-64 9-42 31-76 65-102 23-18 47-31 72-38 32-9 65-7 97 5Z"
                                        fill="#f0fdf4"
                                        stroke="#a7f3d0"
                                        stroke-width="3"
                                    />

                                    @foreach ($mapStates as $item)
                                        <a @if($item['url']) href="{{ $item['url'] }}" @endif>
                                            <circle
                                                cx="{{ $item['x'] }}"
                                                cy="{{ $item['y'] }}"
                                                r="{{ $item['is_complete'] ? 11 : 9 }}"
                                                fill="{{ $item['is_complete'] ? '#047857' : '#bbf7d0' }}"
                                                stroke="{{ $item['is_complete'] ? '#065f46' : '#16a34a' }}"
                                                stroke-width="3"
                                                class="{{ $item['url'] ? 'cursor-pointer transition hover:opacity-80' : '' }}"
                                            />
                                            <text
                                                x="{{ $item['x'] + $item['label_dx'] }}"
                                                y="{{ $item['y'] + $item['label_dy'] }}"
                                                text-anchor="{{ $item['label_anchor'] }}"
                                                fill="#14532d"
                                                font-size="16"
                                                font-weight="800"
                                            >
                                                {{ $item['name_ar'] }}
                                            </text>
                                            <title>{{ $item['name_ar'] }} - {{ $item['entries_count'] }} محتوى - {{ $item['services_count'] }} خدمة</title>
                                        </a>
                                    @endforeach
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
