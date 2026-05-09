<!DOCTYPE html>
<html lang="{{ $currentLocale ?? app()->getLocale() }}" dir="{{ $currentDirection ?? 'rtl' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>بوابة الاستثمار - {{ config('app.name', 'Sudana') }}</title>
        <meta name="description" content="استكشف فرص الاستثمار المنشورة داخل الولايات والمحليات السودانية.">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-stone-50 text-stone-900">
        @include('partials.mobile-header')
        <header class="border-b border-stone-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <div>
                    <a href="{{ route('home') }}" class="text-lg font-black text-emerald-900">Sudana</a>
                    <p class="text-sm text-stone-500">بوابة فرص الاستثمار</p>
                </div>
                <nav class="flex items-center gap-3 text-sm font-bold">
                    <a href="{{ route('home') }}" class="text-stone-600 hover:text-emerald-700">الرئيسية</a>
                    <a href="{{ route('stories.index') }}" class="text-stone-600 hover:text-emerald-700">الحكايات</a>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <section class="rounded-[2rem] bg-gradient-to-l from-emerald-900 via-emerald-800 to-green-700 px-8 py-10 text-white shadow-xl">
                <h1 class="text-4xl font-black">بوابة الاستثمار</h1>
                <p class="mt-4 max-w-3xl text-sm leading-8 text-emerald-50 sm:text-base">
                    هذه هي الطبقة الأولى لعرض الفرص الاستثمارية بشكل منظم وقابل للتوسع إلى العربية والإنجليزية والفرنسية، مع ربط كل فرصة بالولاية والمحلية والجهة المسؤولة.
                </p>
            </section>

            <section class="mt-10">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-2xl font-black text-stone-900">الفرص المنشورة</h2>
                    <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-black text-emerald-800">{{ $opportunities->count() }} فرصة</span>
                </div>

                @if (! ($featureAvailable ?? true))
                    <div class="rounded-3xl border border-dashed border-amber-300 bg-white p-10 text-center text-stone-500">
                        بوابة الاستثمار مضافة في المشروع لكن قاعدة بياناتها لم تُفعّل بعد. بعد تنفيذ الترحيلات ستظهر الفرص هنا تلقائياً.
                    </div>
                @elseif ($opportunities->isEmpty())
                    <div class="rounded-3xl border border-dashed border-stone-300 bg-white p-10 text-center text-stone-500">
                        لا توجد فرص منشورة بعد. البنية أصبحت جاهزة ويمكن الآن تعبئة المحتوى من لوحة الإدارة أو من مساهمات الجهات المختصة.
                    </div>
                @else
                    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($opportunities as $opportunity)
                            <article class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700">{{ $opportunity->category?->name_ar ?? 'قطاع استثماري' }}</p>
                                        <h3 class="mt-2 text-xl font-black text-stone-900">{{ $opportunity->localized('title') }}</h3>
                                    </div>
                                    @if ($opportunity->is_featured)
                                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-black text-amber-900">مميزة</span>
                                    @endif
                                </div>
                                <p class="mt-4 text-sm leading-7 text-stone-600">{{ $opportunity->localized('summary') ?? 'فرصة جاهزة لإضافة ملخص متعدد اللغات.' }}</p>
                                <div class="mt-5 space-y-2 text-sm text-stone-500">
                                    <p>الولاية: <span class="font-bold text-stone-800">{{ $opportunity->state?->name_ar ?? 'غير محددة' }}</span></p>
                                    <p>المحلية: <span class="font-bold text-stone-800">{{ $opportunity->locality?->name_ar ?? 'غير محددة' }}</span></p>
                                    <p>الجهة: <span class="font-bold text-stone-800">{{ $opportunity->office?->localized('name') ?? 'تحت الإعداد' }}</span></p>
                                </div>
                                <a href="{{ route('investment.show', $opportunity->slug) }}" class="mt-6 inline-flex rounded-2xl bg-emerald-700 px-5 py-3 text-sm font-black text-white transition hover:bg-emerald-800">
                                    عرض الفرصة
                                </a>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        </main>
    </body>
</html>
