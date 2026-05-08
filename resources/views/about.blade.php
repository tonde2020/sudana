<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>عن المشروع — {{ config('app.name', 'السودان الرقمي') }}</title>
        <meta name="description" content="قصة السودان الرقمي: مبادرة وطنية لتوثيق الذاكرة، دعم الاستثمار، وتقديم دليل خدمات ذكي لكل ولاية ومحلية.">

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

        <header class="sticky top-0 z-40 border-b border-gray-100 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80" dir="rtl" aria-label="رأس الموقع والتنقل">
            <div class="mx-auto flex h-16 max-w-7xl items-center gap-3 px-4 sm:gap-4 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="shrink-0 font-black text-lg text-gray-900 md:text-xl">
                    السودان الرقمي
                </a>
                <nav class="min-w-0 flex-1 overflow-x-auto [-webkit-overflow-scrolling:touch]" aria-label="روابط الموقع">
                    <ul class="flex items-center gap-4 whitespace-nowrap py-1 text-sm font-black text-gray-600 sm:gap-6 sm:justify-center">
                        <li><a href="{{ url('/') }}" class="transition hover:text-green-700">الرئيسية</a></li>
                        <li><a href="{{ url('/#states') }}" class="transition hover:text-green-700">الولايات</a></li>
                        <li><a href="{{ url('/#virtual-tours') }}" class="transition hover:text-green-700">جولات 360°</a></li>
                        <li><a href="{{ url('/#stats') }}" class="transition hover:text-green-700">أرقام</a></li>
                        <li><a href="{{ url('/#cta') }}" class="transition hover:text-green-700">كن سفيراً</a></li>
                        <li><a href="{{ route('about') }}" class="text-green-700">عن المشروع</a></li>
                        <li><a href="{{ url('/virtual-tours') }}" class="transition hover:text-green-700">كل الجولات</a></li>
                        <li><a href="{{ route('contact') }}" class="transition hover:text-green-700">تواصل</a></li>
                    </ul>
                </nav>
                <div class="flex shrink-0 items-center gap-2 text-sm font-bold sm:gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-lg px-4 py-2 text-gray-700 transition hover:bg-gray-50">
                                لوحة التحكم
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-lg px-4 py-2 text-gray-700 transition hover:bg-gray-50">
                                دخول
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-xl bg-green-700 px-4 py-2 text-white shadow-sm transition hover:bg-green-800">
                                    تسجيل
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <main id="main-content">
            {{-- مقدمة --}}
            <section class="relative overflow-hidden bg-white py-16" dir="rtl">
                <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-green-50/80 via-white to-white"></div>
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <h1 class="text-4xl font-black tracking-tight text-gray-900 sm:text-5xl">
                            عن المشروع
                            <span class="mt-3 block text-2xl font-black text-green-700 sm:text-3xl">مبادرة وطنية… بهدية من مواطن لبلده</span>
                        </h1>
                        <p class="mt-6 text-lg leading-relaxed text-gray-600">
                            «السودان الرقمي» ليس صفحة تعريفية، بل بوابة معرفة وخدمة. هدفها جمع المعلومة الصحيحة في مكان واحد: تاريخ، معالم، شخصيات، محليات، وخدمات… ثم تقديمها بشكل بسيط سريع يناسب واقع الاتصال واحتياج المواطن.
                        </p>
                    </div>
                </div>
            </section>

            {{-- ركائز المشروع --}}
            <section class="bg-white py-20" dir="rtl" aria-labelledby="pillars-heading">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-14 text-center">
                        <h2 id="pillars-heading" class="text-3xl font-black text-gray-900">ركائز المشروع</h2>
                        <p class="mt-4 text-gray-600">ثلاث ركائز… تجمع الهوية، الاقتصاد، وخدمة المواطن.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-10 md:grid-cols-3">
                        <!-- التوثيق الرقمي -->
                        <div class="group text-center">
                            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-3xl bg-green-50 text-green-700 shadow-sm transition duration-500 group-hover:bg-green-700 group-hover:text-white">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="mb-4 text-xl font-black text-gray-800">حفظ الذاكرة الوطنية</h3>
                            <p class="leading-relaxed text-gray-600">توثيق تاريخ الشخصيات والمعالم السودانية ليكون مرجعاً للأجيال القادمة وحمايةً للهوية من الاندثار.</p>
                        </div>

                        <!-- النهضة الاقتصادية -->
                        <div class="group text-center">
                            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-3xl bg-green-50 text-green-700 shadow-sm transition duration-500 group-hover:bg-green-700 group-hover:text-white">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <h3 class="mb-4 text-xl font-black text-gray-800">تحفيز الاستثمار</h3>
                            <p class="leading-relaxed text-gray-600">تسليط الضوء على الفرص الاستثمارية في المحليات لربط المستثمرين بالموارد الحقيقية في كل ولاية.</p>
                        </div>

                        <!-- الخدمة المجتمعية -->
                        <div class="group text-center">
                            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-3xl bg-green-50 text-green-700 shadow-sm transition duration-500 group-hover:bg-green-700 group-hover:text-white">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="mb-4 text-xl font-black text-gray-800">دليل الخدمات الذكي</h3>
                            <p class="leading-relaxed text-gray-600">تسهيل حياة المواطن عبر توفير أرقام الطوارئ والخدمات في المحليات البعيدة بضغطة زر واحدة.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- قصة المشروع وإهداء المواطن --}}
            <section class="overflow-hidden bg-gray-50 py-24" dir="rtl" aria-labelledby="story-heading">
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="pointer-events-none absolute -top-10 -right-10 text-gray-200 opacity-20">
                        <svg class="h-64 w-64" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C14.9124 8 14.017 7.10457 14.017 6V5C14.017 3.89543 14.9124 3 16.017 3H19.017C21.2261 3 23.017 4.79086 23.017 7V15C23.017 18.3137 20.3307 21 17.017 21H14.017ZM1 21L1 18C1 16.8954 1.89543 16 3 16H6C6.55228 16 7 15.5523 7 15V9C7 8.44772 6.55228 8 6 8H3C1.89543 8 1 7.10457 1 6V5C1 3.89543 1.89543 3 3 3H6C8.20914 3 10 4.79086 10 7V15C10 18.3137 7.31371 21 4 21H1Z" /></svg>
                    </div>

                    <div class="relative grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
                        <div>
                            <h2 id="story-heading" class="mb-8 text-3xl font-black leading-tight text-gray-900">
                                من المواطن، إلى الوطن.. <br>
                                <span class="text-green-700">مساهمة في بناء السودان الرقمي.</span>
                            </h2>
                            <div class="space-y-6 text-lg leading-relaxed text-gray-700">
                                <p>
                                    هذا المشروع لم يأتِ بقرار إداري، بل بدأ كفكرة ولدت من حب هذا البلد. هو جهد تطوعي يهدف إلى سد الفجوة الرقمية وتوفير قاعدة بيانات حديثة تخدم نهضة السودان، وتُسهّل الوصول للمعلومة والخدمة في كل ولاية ومحلية.
                                </p>
                                <p>
                                    نؤمن أن توثيق الذاكرة، وتيسير الخدمة، وإبراز الفرص… ليست رفاهية، بل أساس لبلدٍ يسير بثقة نحو المستقبل.
                                </p>
                                <blockquote class="rounded-2xl border-r-8 border-green-700 bg-white p-6 font-semibold text-gray-900 shadow-sm">
                                    “أُهدي هذا العمل المتواضع لبلدي السودان، ولأهلي في كل ولاية ومحلية. هو دعوة لكل شاب وشابة للمساهمة في توثيق جمال وتاريخ بلدهم.”
                                    <span class="mt-4 block text-sm font-black text-green-700">— مطور المشروع</span>
                                </blockquote>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="absolute -inset-4 rotate-3 rounded-[3rem] bg-green-700/10"></div>
                            <img
                                src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=1400&q=80"
                                alt="نهضة السودان"
                                loading="lazy"
                                decoding="async"
                                class="relative h-[500px] w-full rounded-[3rem] object-cover shadow-2xl"
                            >
                        </div>
                    </div>
                </div>
            </section>

            {{-- دعوة للعمل --}}
            <section class="bg-white py-20 text-center" dir="rtl" aria-labelledby="final-cta-heading">
                <div class="mx-auto max-w-3xl px-4">
                    <h2 id="final-cta-heading" class="mb-6 text-2xl font-black text-gray-900">المنصة ملك لكل سوداني</h2>
                    <p class="mb-10 text-lg text-gray-600">
                        باب التطوع مفتوح كـ “سفير ولاية” أو “كاتب مقال”. معاً نبني المرجع الرقمي الأكبر لولاياتنا… خطوة بخطوة وبمعلومة موثّقة.
                    </p>
                    <div class="flex flex-col justify-center gap-4 sm:flex-row">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-2xl bg-green-700 px-12 py-4 font-black text-white shadow-lg transition hover:bg-green-800">
                                سجل كمساهم الآن
                            </a>
                        @else
                            <a href="{{ url('/register') }}" class="rounded-2xl bg-green-700 px-12 py-4 font-black text-white shadow-lg transition hover:bg-green-800">
                                سجل كمساهم الآن
                            </a>
                        @endif
                        <a href="{{ route('contact') }}" class="rounded-2xl bg-gray-100 px-12 py-4 font-black text-gray-700 transition hover:bg-gray-200">
                            تواصل معنا
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-gray-100 bg-gray-50 py-10" dir="rtl">
            <div class="mx-auto max-w-7xl px-4 text-center text-sm text-gray-500 sm:px-6 lg:px-8">
                <p class="font-bold text-gray-700">{{ config('app.name', 'السودان الرقمي') }}</p>
                <p class="mt-2">عن المشروع — مبادرة وطنية مفتوحة لكل سوداني.</p>
            </div>
        </footer>
    </body>
</html>

