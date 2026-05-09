<!DOCTYPE html>
<html lang="{{ $currentLocale ?? app()->getLocale() }}" dir="{{ $currentDirection ?? 'rtl' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>بوابة الحكايات - {{ config('app.name', 'Sudana') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-amber-50/40 text-stone-900">
        @include('partials.mobile-header')
        <header class="border-b border-amber-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <div>
                    <a href="{{ route('home') }}" class="text-lg font-black text-amber-900">Sudana</a>
                    <p class="text-sm text-stone-500">بوابة الحكايات والنوادر والأحاجي</p>
                </div>
                <nav class="flex items-center gap-3 text-sm font-bold">
                    <a href="{{ route('investment.index') }}" class="text-stone-600 hover:text-amber-700">الاستثمار</a>
                    <a href="{{ route('home') }}" class="text-stone-600 hover:text-amber-700">الرئيسية</a>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <section class="rounded-[2rem] bg-gradient-to-l from-amber-950 via-orange-900 to-amber-700 px-8 py-10 text-white shadow-xl">
                <h1 class="text-4xl font-black">بوابة الحكايات والهوية</h1>
                <p class="mt-4 max-w-3xl text-sm leading-8 text-amber-50 sm:text-base">
                    مساحة تحفظ السرد المحلي: قصص، نوادر، أحاجي، أمثال، وشخصيات مرتبطة بالولاية والمحلية والمجتمع.
                </p>
            </section>

            <section class="mt-10">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-2xl font-black text-stone-900">المواد المنشورة</h2>
                    <span class="rounded-full bg-amber-100 px-4 py-2 text-sm font-black text-amber-900">{{ $stories->count() }} مادة</span>
                </div>

                @if (! ($featureAvailable ?? true))
                    <div class="rounded-3xl border border-dashed border-amber-300 bg-white p-10 text-center text-stone-500">
                        بوابة الحكايات مضافة في المشروع لكن جداولها لم تُفعّل بعد. بعد تنفيذ الترحيلات ستظهر المواد هنا تلقائياً.
                    </div>
                @elseif ($stories->isEmpty())
                    <div class="rounded-3xl border border-dashed border-amber-300 bg-white p-10 text-center text-stone-500">
                        لا توجد حكايات منشورة بعد. طبقة البيانات أصبحت جاهزة لإدخال القصص والنوادر والأحاجي وربطها بالشخصيات والمناطق.
                    </div>
                @else
                    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($stories as $story)
                            <article class="rounded-3xl border border-amber-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-amber-700">{{ $story->story_type }}</p>
                                <h3 class="mt-3 text-xl font-black text-stone-900">{{ $story->localized('title') }}</h3>
                                <p class="mt-4 text-sm leading-7 text-stone-600">{{ $story->localized('summary') ?? 'وصف قصير للمادة السردية سيظهر هنا.' }}</p>
                                <div class="mt-5 space-y-2 text-sm text-stone-500">
                                    <p>الولاية: <span class="font-bold text-stone-800">{{ $story->state?->name_ar ?? 'غير محددة' }}</span></p>
                                    <p>المحلية: <span class="font-bold text-stone-800">{{ $story->locality?->name_ar ?? 'غير محددة' }}</span></p>
                                    <p>الشخصية: <span class="font-bold text-stone-800">{{ $story->person?->localized('name') ?? 'غير مرتبطة' }}</span></p>
                                </div>
                                <a href="{{ route('stories.show', $story->slug) }}" class="mt-6 inline-flex rounded-2xl bg-amber-700 px-5 py-3 text-sm font-black text-white transition hover:bg-amber-800">
                                    قراءة المادة
                                </a>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        </main>
    </body>
</html>
