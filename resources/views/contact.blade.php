<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>تواصل معنا — {{ config('app.name', 'السودان الرقمي') }}</title>
        <meta name="description" content="تواصل مع فريق السودان الرقمي للاقتراحات وتصحيح المعلومات والتعاون.">

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

        <header class="sticky top-0 z-40 border-b border-gray-100 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80" dir="rtl">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="font-black text-lg text-gray-900 md:text-xl">السودان الرقمي</a>
                <nav class="text-sm font-black text-gray-600" aria-label="روابط سريعة">
                    <ul class="flex items-center gap-4">
                        <li><a href="{{ route('about') }}" class="transition hover:text-green-700">عن المشروع</a></li>
                        <li><a href="{{ route('contact') }}" class="text-green-700">تواصل</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main id="main-content">
            <section class="bg-white py-16" dir="rtl">
                <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-black text-gray-900">تواصل معنا</h1>
                    <p class="mt-4 text-lg leading-relaxed text-gray-600">
                        نرحّب بالاقتراحات وتصحيح المعلومات وإرسال مصادر موثوقة. رسالتك تساعدنا في رفع جودة التوثيق وخدمة المواطن.
                    </p>

                    <div class="mt-10 rounded-3xl border border-gray-100 bg-gray-50 p-8">
                        <p class="text-sm font-black text-gray-900">ملاحظة</p>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">
                            صفحة التواصل هذه جاهزة بصرياً. لاحقاً يمكن ربطها بنموذج إرسال (Email) أو نظام تذاكر، مع حفظ المرفقات والمصادر.
                        </p>

                        <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                            <a href="{{ url('/') }}" class="rounded-2xl bg-white px-6 py-3 text-center text-sm font-black text-green-700 ring-1 ring-green-200 transition hover:bg-green-50">
                                العودة للرئيسية
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-2xl bg-green-700 px-6 py-3 text-center text-sm font-black text-white shadow-sm transition hover:bg-green-800">
                                    سجّل كمساهم
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-gray-100 bg-gray-50 py-10" dir="rtl">
            <div class="mx-auto max-w-7xl px-4 text-center text-sm text-gray-500 sm:px-6 lg:px-8">
                <p class="font-bold text-gray-700">{{ config('app.name', 'السودان الرقمي') }}</p>
                <p class="mt-2">تواصل معنا — لأن الدقة مسؤوليتنا جميعاً.</p>
            </div>
        </footer>
    </body>
</html>

