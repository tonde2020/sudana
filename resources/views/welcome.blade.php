<!DOCTYPE html>
<html lang="{{ $currentLocale ?? app()->getLocale() }}" dir="{{ $currentDirection ?? 'rtl' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">
        <title>{{ config('app.name', 'السودان الرقمي') }} - دليل السودان الرقمي</title>
        <meta name="description" content="منصة تجمع الخدمات والفرص الاستثمارية والحكايات المحلية في واجهة واحدة تخدم الولايات والمحليات.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            body { font-family: 'Cairo', ui-sans-serif, system-ui, sans-serif; }

            .hero-night-scene {
                background-image:
                    linear-gradient(90deg, rgba(3, 11, 22, 0.88) 0%, rgba(3, 11, 22, 0.72) 34%, rgba(3, 11, 22, 0.42) 58%, rgba(3, 11, 22, 0.16) 100%),
                    linear-gradient(180deg, rgba(4, 10, 18, 0.78) 0%, rgba(4, 10, 18, 0.42) 32%, rgba(4, 10, 18, 0.3) 62%, rgba(4, 10, 18, 0.56) 100%),
                    url('/images/hero-sudan-village.png');
                background-position: center, center, center;
                background-repeat: no-repeat;
                background-size: cover;
                isolation: isolate;
            }

            .hero-sky-stars {
                background-image:
                    radial-gradient(circle at 12% 22%, rgba(255, 255, 255, 0.95) 0 1.2px, transparent 1.8px),
                    radial-gradient(circle at 26% 16%, rgba(197, 235, 255, 0.9) 0 1px, transparent 1.6px),
                    radial-gradient(circle at 38% 28%, rgba(255, 245, 213, 0.92) 0 1.4px, transparent 2px),
                    radial-gradient(circle at 54% 14%, rgba(255, 255, 255, 0.92) 0 1.2px, transparent 1.8px),
                    radial-gradient(circle at 63% 31%, rgba(179, 231, 255, 0.9) 0 1px, transparent 1.7px),
                    radial-gradient(circle at 72% 10%, rgba(255, 248, 223, 0.94) 0 1.5px, transparent 2.2px),
                    radial-gradient(circle at 84% 24%, rgba(255, 255, 255, 0.95) 0 1.2px, transparent 1.9px),
                    radial-gradient(circle at 91% 17%, rgba(197, 235, 255, 0.9) 0 1px, transparent 1.7px);
                opacity: 0.8;
                animation: heroTwinkle 7s ease-in-out infinite alternate;
            }

            .hero-meteor {
                position: absolute;
                top: var(--meteor-top);
                left: var(--meteor-left);
                width: var(--meteor-width);
                height: 2px;
                border-radius: 9999px;
                background: linear-gradient(90deg, rgba(255,255,255,0), rgba(255,249,225,1) 55%, rgba(168,227,255,0.05));
                transform: rotate(-24deg);
                opacity: 0;
                filter: drop-shadow(0 0 10px rgba(198, 233, 255, 0.5));
                animation: heroMeteor var(--meteor-duration) linear infinite;
                animation-delay: var(--meteor-delay);
            }

            .hero-dunes {
                position: absolute;
                inset-inline: 0;
                bottom: -1px;
                height: 10rem;
                background:
                    linear-gradient(180deg, rgba(3, 11, 22, 0) 0%, rgba(3, 11, 22, 0.08) 18%, rgba(3, 11, 22, 0.74) 100%),
                    radial-gradient(90% 90% at 12% 100%, rgba(9, 28, 45, 0.92) 0%, rgba(9, 28, 45, 0.88) 62%, transparent 63%),
                    radial-gradient(82% 88% at 44% 100%, rgba(11, 36, 56, 0.88) 0%, rgba(11, 36, 56, 0.84) 61%, transparent 62%),
                    radial-gradient(78% 88% at 78% 100%, rgba(17, 46, 67, 0.86) 0%, rgba(17, 46, 67, 0.82) 60%, transparent 61%);
                pointer-events: none;
            }

            .hero-night-vignette {
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at 78% 16%, rgba(255, 249, 218, 0.14), transparent 12%),
                    radial-gradient(circle at 18% 76%, rgba(38, 118, 154, 0.16), transparent 24%),
                    linear-gradient(180deg, rgba(7, 14, 22, 0.02) 0%, rgba(7, 14, 22, 0.18) 55%, rgba(7, 14, 22, 0.48) 100%);
                pointer-events: none;
            }

            @keyframes heroTwinkle {
                0% { opacity: 0.45; transform: translateY(0); }
                100% { opacity: 0.88; transform: translateY(-2px); }
            }

            @keyframes heroMeteor {
                0% {
                    opacity: 0;
                    transform: translate3d(0, 0, 0) rotate(-24deg) scaleX(0.3);
                }
                8% {
                    opacity: 1;
                }
                28% {
                    opacity: 0;
                    transform: translate3d(240px, 120px, 0) rotate(-24deg) scaleX(1);
                }
                100% {
                    opacity: 0;
                    transform: translate3d(240px, 120px, 0) rotate(-24deg) scaleX(1);
                }
            }

        </style>
    </head>
    <body class="min-h-screen bg-[#fcfdfb] text-gray-900 antialiased">
        @include('partials.mobile-header')

        <a href="#main-content" class="fixed start-4 top-2 z-[100] -translate-y-[calc(100%+0.5rem)] rounded-lg bg-green-700 px-4 py-2 text-sm font-black text-white shadow-md transition-transform focus:translate-y-2 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-800">
            تخط إلى المحتوى
        </a>

        <main id="main-content">
            <section class="hero-night-scene relative overflow-hidden lg:min-h-[640px] lg:pt-8" dir="{{ $currentDirection ?? 'rtl' }}">
                <div class="hero-sky-stars absolute inset-0 opacity-50"></div>
                <div class="hero-night-vignette"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(111,255,207,0.10),_transparent_25%),linear-gradient(180deg,rgba(18,70,83,0.05),transparent_40%)]"></div>
                <span class="hero-meteor" aria-hidden="true" style="--meteor-top: 6.5rem; --meteor-left: 63%; --meteor-width: 7rem; --meteor-duration: 7.2s; --meteor-delay: -0.5s;"></span>
                <span class="hero-meteor" aria-hidden="true" style="--meteor-top: 10rem; --meteor-left: 78%; --meteor-width: 5.75rem; --meteor-duration: 8.8s; --meteor-delay: -2.1s;"></span>
                <span class="hero-meteor" aria-hidden="true" style="--meteor-top: 13rem; --meteor-left: 70%; --meteor-width: 6.5rem; --meteor-duration: 6.9s; --meteor-delay: -4.4s;"></span>
                <div class="relative mx-auto max-w-7xl px-6 py-16 sm:px-6 lg:flex lg:min-h-[650px] lg:items-center lg:px-8 lg:py-24">
                    <div class="w-full max-w-4xl">
                        <div class="relative z-10 p-7 sm:p-10">
                            <div class="mb-10">
                                <span class="inline-flex items-center rounded-full border border-[#f4d27f]/30 bg-transparent px-4 py-1.5 text-[11px] font-bold uppercase tracking-[0.25em] text-[#f4d27f]">
                                    <span class="ml-2 h-1.5 w-1.5 rounded-full bg-[#f4d27f] animate-pulse"></span>
                                    Sudan Digital Guide
                                </span>
                            </div>
                            <h1 class="text-4xl font-black leading-[1.15] tracking-tight text-white drop-shadow-md sm:text-6xl lg:text-7xl">
                                منصة واحدة تجمع
                                <span class="block text-[#f4d27f]">الخدمات والاستثمار والحكايات</span>
                            </h1>
                            <p class="mt-8 max-w-2xl text-xl font-medium leading-relaxed text-white/90 drop-shadow-sm">
                                واجهة حديثة للولايات والمحليات السودانية: دليل خدمات عملي، فرص استثمار موثقة، وطبقة سردية تحفظ الإرث والحكايات المحلية.
                            </p>

                            <div class="mt-12 flex flex-wrap gap-5">
                                <a href="{{ route('investment.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-[#f4d27f] px-10 py-4 text-base font-black text-[#1b1304] shadow-xl shadow-[#f4d27f]/20 transition-all hover:scale-105 hover:bg-[#eec056]">استكشف الاستثمار</a>
                                <a href="{{ route('stories.index') }}" class="inline-flex items-center justify-center rounded-2xl border-2 border-white px-10 py-4 text-base font-black text-white transition hover:bg-white hover:text-[#1b1304]">ادخل الحكايات</a>
                            </div>

                            <div class="mt-16 w-full max-w-2xl group">
                                <form action="{{ url('/') }}" method="get" class="flex flex-col overflow-hidden rounded-2xl bg-white p-1.5 shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-transform focus-within:scale-[1.02] sm:flex-row" role="search" aria-label="البحث في الدليل">
                                    <label for="site-search" class="sr-only">البحث في الدليل</label>
                                    <input
                                        id="site-search"
                                        name="q"
                                        type="search"
                                        value="{{ request('q') }}"
                                        placeholder="ابحث عن ولاية، محلية، أو خدمة..."
                                        class="w-full flex-1 border-0 bg-transparent px-6 py-4 text-lg font-bold text-gray-900 placeholder:text-gray-400 focus:ring-0"
                                        autocomplete="off"
                                    >
                                    <button type="submit" class="shrink-0 rounded-xl bg-[#f4d27f] px-10 py-4 text-sm font-black text-[#1b1304] transition-colors hover:bg-[#eec056]">
                                        بحث سريع
                                    </button>
                                </form>
                                <div class="mt-4 flex gap-4 px-2">
                                    <span class="text-xs font-bold text-[#f4d27f]">الولايات الأكثر بحثاً:</span>
                                    <span class="text-xs text-white/60">الخرطوم، البحر الأحمر، الشمالية</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-dunes opacity-30" aria-hidden="true"></div>
            </section>

            <section id="states" class="scroll-mt-20 bg-gray-50 py-16" aria-labelledby="states-heading" dir="{{ $currentDirection ?? 'rtl' }}">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 text-center">
                        <h2 id="states-heading" class="text-3xl font-black text-gray-900">ولايات السودان</h2>
                        <p class="mt-4 text-gray-600">كل ولاية صفحة مستقلة تنطلق منها الخدمات والمعالم والمحتوى المحلي.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-6">
                        @foreach ($states as $state)
                            <a href="{{ route('states.show', $state->slug) }}" class="group relative rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-green-600">
                                <div class="flex flex-col items-center text-center">
                                    <img src="{{ $state->logo_url }}" alt="" width="64" height="64" loading="lazy" decoding="async" class="mb-4 h-16 w-16 grayscale transition duration-300 group-hover:grayscale-0">
                                    <h3 class="text-lg font-black text-gray-800 transition group-hover:text-green-700">{{ $state->name_ar }}</h3>
                                    <span class="mt-2 text-xs text-gray-400">{{ $state->localities_count }} محلية</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="virtual-tours" class="scroll-mt-20 bg-white py-16" aria-labelledby="tours-heading" dir="{{ $currentDirection ?? 'rtl' }}">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 id="tours-heading" class="text-3xl font-black text-gray-900">جولات افتراضية</h2>
                            <p class="mt-2 text-gray-500">معاينة بصرية للمعالم والوجهات عبر صور 360 درجة ومشاهد بانورامية.</p>
                        </div>
                        <a href="{{ route('map') }}" class="font-black text-green-700 hover:underline">استكشف عبر الخريطة</a>
                    </div>

                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                        @forelse ($featuredTours as $tour)
                            <a href="{{ $tour['url'] }}" class="group relative block h-64 overflow-hidden rounded-3xl shadow-md transition hover:shadow-lg">
                                <img src="{{ $tour['src'] }}" alt="جولة افتراضية - {{ $tour['title'] }}" loading="lazy" decoding="async" class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                <div class="absolute inset-x-6 bottom-6">
                                    <span class="mb-2 inline-block rounded-full bg-red-600 px-3 py-1 text-xs font-black text-white">360° VR</span>
                                    <h4 class="text-2xl font-black text-white">{{ $tour['title'] }}</h4>
                                    <span class="mt-1 block text-sm text-white/80">{{ $tour['tag'] }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="md:col-span-2 rounded-3xl border border-dashed border-gray-200 bg-gray-50 p-10 text-center text-gray-500">
                                لا توجد جولات افتراضية منشورة بعد. أضف جولة من لوحة الإدارة لتظهر هنا.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="stats" class="scroll-mt-20 bg-gray-900 py-14 text-white" aria-labelledby="stats-heading" dir="{{ $currentDirection ?? 'rtl' }}">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-sm font-black uppercase tracking-[0.3em] text-green-300">لوحة سريعة</p>
                            <h2 id="stats-heading" class="mt-3 text-3xl font-black">أرقام المنصة</h2>
                        </div>
                        <div class="text-sm font-bold text-gray-300">تغطي الدليل والخدمات والبوابات الجديدة</div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <div class="rounded-3xl bg-white/5 px-5 py-6 ring-1 ring-white/10">
                            <div class="text-3xl font-black">{{ $stats['states'] }}</div>
                            <div class="mt-2 text-sm font-bold text-green-200">ولاية</div>
                        </div>
                        <div class="rounded-3xl bg-white/5 px-5 py-6 ring-1 ring-white/10">
                            <div class="text-3xl font-black">{{ $stats['localities'] > 0 ? '+' . $stats['localities'] : 0 }}</div>
                            <div class="mt-2 text-sm font-bold text-green-200">محلية</div>
                        </div>
                        <div class="rounded-3xl bg-white/5 px-5 py-6 ring-1 ring-white/10">
                            <div class="text-3xl font-black">{{ $stats['entries'] > 0 ? '+' . $stats['entries'] : 0 }}</div>
                            <div class="mt-2 text-sm font-bold text-green-200">مادة منشورة</div>
                        </div>
                        <div class="rounded-3xl bg-white/5 px-5 py-6 ring-1 ring-white/10">
                            <div class="text-3xl font-black">{{ $stats['services'] > 0 ? '+' . $stats['services'] : 0 }}</div>
                            <div class="mt-2 text-sm font-bold text-green-200">خدمة</div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="cta" class="scroll-mt-20 bg-white py-20" aria-labelledby="cta-heading" dir="{{ $currentDirection ?? 'rtl' }}">
                <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                    <div class="rounded-[3rem] border border-green-100 bg-green-50 p-10 text-center shadow-sm sm:p-12">
                        <h2 id="cta-heading" class="mb-6 text-3xl font-black text-gray-900">كن سفيراً لولايتك</h2>
                        <p class="mx-auto mb-10 max-w-2xl text-lg leading-relaxed text-gray-600">
                            المنصة تكبر عندما يشارك أبناء الولايات بمعلومات صحيحة وصور ومصادر وفرص وخدمات وقصص محلية موثقة.
                        </p>
                        <div class="flex flex-col justify-center gap-4 sm:flex-row">
                            <a href="{{ route('volunteer.create') }}" class="rounded-xl bg-green-700 px-10 py-4 font-black text-white shadow-lg transition hover:bg-green-800">
                                انضم للمساهمة
                            </a>
                            <a href="{{ route('about') }}" class="rounded-xl border border-green-200 bg-white px-10 py-4 font-black text-green-700 transition hover:bg-gray-50">
                                تعرّف على المشروع
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-gray-100 bg-gray-50 py-10" dir="{{ $currentDirection ?? 'rtl' }}">
            <div class="mx-auto max-w-7xl px-4 text-center text-sm text-gray-500 sm:px-6 lg:px-8">
                <p class="font-bold text-gray-700">{{ config('app.name', 'السودان الرقمي') }}</p>
                <p class="mt-2">بوابة وطنية تجمع المعرفة والخدمة والفرص والذاكرة المحلية في تجربة واحدة.</p>
            </div>
        </footer>
    </body>
</html>
