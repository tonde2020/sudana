<!DOCTYPE html>
<html lang="{{ $currentLocale ?? app()->getLocale() }}" dir="{{ $currentDirection ?? 'rtl' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $opportunity->localized('title') }} - بوابة الاستثمار</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-white text-stone-900">
        @include('partials.mobile-header')
        <header class="border-b border-stone-200 bg-stone-50">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('investment.index') }}" class="text-sm font-black text-emerald-800 hover:underline">العودة إلى بوابة الاستثمار</a>
                <a href="{{ route('home') }}" class="text-sm font-black text-stone-700 hover:text-emerald-700">الرئيسية</a>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[1.25fr_0.75fr]">
                <section>
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700">{{ $opportunity->category?->name_ar ?? 'قطاع استثماري' }}</p>
                    <h1 class="mt-3 text-4xl font-black text-stone-900">{{ $opportunity->localized('title') }}</h1>
                    <p class="mt-4 text-lg leading-8 text-stone-600">{{ $opportunity->localized('summary') }}</p>

                    <div class="mt-8 rounded-3xl bg-stone-50 p-6">
                        <h2 class="text-xl font-black text-stone-900">وصف الفرصة</h2>
                        <div class="mt-4 whitespace-pre-line text-sm leading-8 text-stone-700">{{ $opportunity->localized('description') ?? 'لم تتم إضافة الوصف التفصيلي بعد.' }}</div>
                    </div>

                    <div class="mt-8 grid gap-6 md:grid-cols-2">
                        <div class="rounded-3xl border border-stone-200 p-6">
                            <h3 class="text-lg font-black text-stone-900">الحوافز</h3>
                            <p class="mt-3 whitespace-pre-line text-sm leading-7 text-stone-600">{{ $opportunity->localized('incentives') ?? 'سيتم إدراج الحوافز الاستثمارية هنا.' }}</p>
                        </div>
                        <div class="rounded-3xl border border-stone-200 p-6">
                            <h3 class="text-lg font-black text-stone-900">المخاطر والملاحظات</h3>
                            <p class="mt-3 whitespace-pre-line text-sm leading-7 text-stone-600">{{ $opportunity->localized('risks') ?? 'سيتم إدراج الاعتبارات والمخاطر هنا.' }}</p>
                        </div>
                    </div>
                </section>

                <aside class="space-y-6">
                    <div class="rounded-3xl bg-emerald-900 p-6 text-white">
                        <h2 class="text-lg font-black">بطاقة سريعة</h2>
                        <div class="mt-4 space-y-3 text-sm text-emerald-50">
                            <p>الولاية: <span class="font-black text-white">{{ $opportunity->state?->name_ar ?? 'غير محددة' }}</span></p>
                            <p>المحلية: <span class="font-black text-white">{{ $opportunity->locality?->name_ar ?? 'غير محددة' }}</span></p>
                            <p>نوع الاستثمار: <span class="font-black text-white">{{ $opportunity->investment_type ?? 'تحت الإعداد' }}</span></p>
                            <p>الجاهزية: <span class="font-black text-white">{{ $opportunity->readiness_status ?? 'تحت الإعداد' }}</span></p>
                            <p>نطاق رأس المال: <span class="font-black text-white">{{ $opportunity->capital_range ?? 'تحت الإعداد' }}</span></p>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-stone-200 p-6">
                        <h2 class="text-lg font-black text-stone-900">جهة التواصل</h2>
                        <div class="mt-4 space-y-3 text-sm text-stone-600">
                            <p>الجهة: <span class="font-black text-stone-900">{{ $opportunity->office?->localized('name') ?? 'غير محددة' }}</span></p>
                            <p>الاسم: <span class="font-black text-stone-900">{{ $opportunity->contact_name ?? 'غير محدد' }}</span></p>
                            <p>البريد: <span class="font-black text-stone-900">{{ $opportunity->contact_email ?? 'غير محدد' }}</span></p>
                            <p>الهاتف: <span class="font-black text-stone-900">{{ $opportunity->contact_phone ?? 'غير محدد' }}</span></p>
                        </div>
                    </div>

                    @if ($relatedOpportunities->isNotEmpty())
                        <div class="rounded-3xl border border-stone-200 p-6">
                            <h2 class="text-lg font-black text-stone-900">فرص ذات صلة</h2>
                            <div class="mt-4 space-y-4">
                                @foreach ($relatedOpportunities as $related)
                                    <a href="{{ route('investment.show', $related->slug) }}" class="block rounded-2xl bg-stone-50 px-4 py-3 text-sm font-bold text-stone-700 transition hover:bg-stone-100">
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
