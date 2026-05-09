<!DOCTYPE html>
<html lang="{{ $currentLocale ?? app()->getLocale() }}" dir="{{ $currentDirection ?? 'rtl' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>تواصل معنا — {{ config('app.name', 'السودان الرقمي') }}</title>
        <meta name="description" content="صفحة تواصل مخصصة للملاحظات، تصحيح المعلومات، المساهمات، والتعاون حول السودان الرقمي.">

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
                        <li><a href="{{ route('about') }}" class="transition hover:text-green-700">عن المشروع</a></li>
                        <li><a href="{{ route('investment.index') }}" class="transition hover:text-green-700">الاستثمار</a></li>
                        <li><a href="{{ route('stories.index') }}" class="transition hover:text-green-700">الحكايات</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <section class="relative overflow-hidden bg-white py-16" dir="{{ $currentDirection ?? 'rtl' }}">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.12),_transparent_35%)]"></div>
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-start">
                        <div>
                            <p class="text-sm font-black uppercase tracking-[0.3em] text-green-700">Contact & Collaboration</p>
                            <h1 class="mt-4 text-4xl font-black text-gray-900 sm:text-5xl">هذه الصفحة لفتح الخط مع المنصة</h1>
                            <p class="mt-6 text-lg leading-9 text-gray-600">إذا عندك تصحيح معلومة، رغبة في المساهمة، محتوى استثماري، أو مادة ثقافية محلية، فهذه هي نقطة الدخول الأنسب.</p>

                            <div class="mt-8 grid gap-4">
                                <div class="rounded-[2rem] border border-gray-200 bg-white p-6 shadow-sm">
                                    <h2 class="text-xl font-black text-gray-900">أفضل أنواع الرسائل حالياً</h2>
                                    <ul class="mt-4 grid gap-3 text-sm leading-7 text-gray-600">
                                        <li>تصحيح معلومة في خدمة أو رقم أو جهة.</li>
                                        <li>إرسال فرصة استثمار أو ملف تعريفي لولاية أو محلية.</li>
                                        <li>مشاركة قصة أو أحجية أو شخصية محلية تستحق التوثيق.</li>
                                        <li>طلب الانضمام كمساهم أو سفير للولاية.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-[2rem] border border-green-100 bg-green-50 p-6 shadow-sm">
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-green-700">ساهم</p>
                                <h3 class="mt-3 text-2xl font-black text-gray-900">مساهمة مجتمعية</h3>
                                <p class="mt-3 text-sm leading-8 text-gray-600">أسرع طريق الآن هو الدخول عبر نموذج الانضمام والمساهمة.</p>
                                <a href="{{ route('volunteer.create') }}" class="mt-5 inline-flex rounded-2xl bg-green-700 px-5 py-3 text-sm font-black text-white transition hover:bg-green-800">اذهب إلى نموذج المساهمة</a>
                            </div>

                            <div class="rounded-[2rem] border border-emerald-100 bg-white p-6 shadow-sm">
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-emerald-700">Admin</p>
                                <h3 class="mt-3 text-2xl font-black text-gray-900">لوحة الإدارة</h3>
                                <p class="mt-3 text-sm leading-8 text-gray-600">إذا لديك صلاحيات، يمكنك إضافة فرص الاستثمار والحكايات مباشرة من لوحة التحكم.</p>
                                <a href="{{ route('contributor.login') }}" class="mt-5 inline-flex rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm font-black text-emerald-800 transition hover:bg-emerald-100">دخول المساهم</a>
                            </div>

                            <div class="rounded-[2rem] border border-amber-100 bg-amber-50 p-6 shadow-sm sm:col-span-2">
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-amber-700">Next Step</p>
                                <h3 class="mt-3 text-2xl font-black text-gray-900">ربط الصفحة بنموذج إرسال مباشر</h3>
                                <p class="mt-3 text-sm leading-8 text-gray-600">بصرياً الصفحة أصبحت جاهزة. والخطوة التالية المنطقية هي ربطها بنموذج فعلي يرسل ملاحظات وتعديلات ومرفقات إلى الإدارة أو البريد.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-gray-100 bg-gray-50 py-10" dir="{{ $currentDirection ?? 'rtl' }}">
            <div class="mx-auto max-w-7xl px-4 text-center text-sm text-gray-500 sm:px-6 lg:px-8">
                <p class="font-bold text-gray-700">{{ config('app.name', 'السودان الرقمي') }}</p>
                <p class="mt-2">تواصل معنا — لأن دقة المحتوى وجودته مسؤولية مشتركة.</p>
            </div>
        </footer>
    </body>
</html>
