<!DOCTYPE html>
<html lang="{{ $currentLocale ?? app()->getLocale() }}" dir="{{ $currentDirection ?? 'rtl' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $story->localized('title') }} - بوابة الحكايات</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-white text-stone-900">
        @include('partials.mobile-header')
        <header class="border-b border-amber-200 bg-amber-50/60">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('stories.index') }}" class="text-sm font-black text-amber-800 hover:underline">العودة إلى بوابة الحكايات</a>
                <a href="{{ route('home') }}" class="text-sm font-black text-stone-700 hover:text-amber-700">الرئيسية</a>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr]">
                <section>
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-amber-700">{{ $story->story_type }}</p>
                    <h1 class="mt-3 text-4xl font-black text-stone-900">{{ $story->localized('title') }}</h1>
                    <p class="mt-4 text-lg leading-8 text-stone-600">{{ $story->localized('summary') }}</p>

                    <div class="mt-8 rounded-3xl bg-amber-50/70 p-6">
                        <h2 class="text-xl font-black text-stone-900">النص</h2>
                        <div class="mt-4 whitespace-pre-line text-sm leading-8 text-stone-700">{{ $story->localized('content') ?? 'سيظهر النص الكامل هنا بعد إدخال المحتوى.' }}</div>
                    </div>

                    <div class="mt-8 rounded-3xl border border-amber-200 p-6">
                        <h2 class="text-xl font-black text-stone-900">التفسير أو الشرح</h2>
                        <p class="mt-4 whitespace-pre-line text-sm leading-8 text-stone-700">{{ $story->localized('interpretation') ?? 'يمكن استخدام هذا القسم لشرح الأحجية أو دلالة الحكاية أو سياقها الثقافي.' }}</p>
                    </div>
                </section>

                <aside class="space-y-6">
                    <div class="rounded-3xl bg-amber-900 p-6 text-white">
                        <h2 class="text-lg font-black">بطاقة سريعة</h2>
                        <div class="mt-4 space-y-3 text-sm text-amber-50">
                            <p>النوع: <span class="font-black text-white">{{ $story->story_type }}</span></p>
                            <p>الولاية: <span class="font-black text-white">{{ $story->state?->name_ar ?? 'غير محددة' }}</span></p>
                            <p>المحلية: <span class="font-black text-white">{{ $story->locality?->name_ar ?? 'غير محددة' }}</span></p>
                            <p>الراوي: <span class="font-black text-white">{{ $story->narrator_name ?? 'غير محدد' }}</span></p>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-amber-200 p-6">
                        <h2 class="text-lg font-black text-stone-900">الشخصية المرتبطة</h2>
                        @if ($story->person)
                            <p class="mt-3 text-sm font-black text-stone-900">{{ $story->person->localized('name') }}</p>
                            <p class="mt-2 text-sm leading-7 text-stone-600">{{ $story->person->localized('headline') ?? 'شخصية محلية مرتبطة بهذه المادة.' }}</p>
                        @else
                            <p class="mt-3 text-sm text-stone-500">لا توجد شخصية مرتبطة بهذه المادة حتى الآن.</p>
                        @endif
                    </div>

                    @if ($relatedStories->isNotEmpty())
                        <div class="rounded-3xl border border-amber-200 p-6">
                            <h2 class="text-lg font-black text-stone-900">مواد ذات صلة</h2>
                            <div class="mt-4 space-y-4">
                                @foreach ($relatedStories as $related)
                                    <a href="{{ route('stories.show', $related->slug) }}" class="block rounded-2xl bg-amber-50 px-4 py-3 text-sm font-bold text-stone-700 transition hover:bg-amber-100">
                                        {{ $related->localized('title') }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </main>
    </body>
</html>
