<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $entry->title }} - {{ config('app.name', 'السودان الرقمي') }}</title>
        <meta name="description" content="{{ $entry->excerpt ?: strip_tags($entry->title) }}">

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
        <a href="#main-content" class="fixed start-4 top-2 z-[100] -translate-y-[calc(100%+0.5rem)] rounded-lg bg-green-700 px-4 py-2 text-sm font-black text-white shadow-md transition-transform focus:translate-y-2 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-800">
            تخطي إلى المحتوى
        </a>

        <header class="border-b border-gray-100 bg-white" dir="rtl">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4 sm:py-2 lg:px-8">
                <div class="flex min-w-0 flex-1 flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ url('/') }}" class="shrink-0 font-black text-green-800 transition hover:text-green-900">السودان الرقمي</a>
                    <nav class="min-w-0 overflow-x-auto [-webkit-overflow-scrolling:touch]" aria-label="روابط الموقع">
                        <ul class="flex flex-wrap items-center gap-x-4 gap-y-2 whitespace-nowrap text-sm font-black text-gray-600 sm:gap-5">
                            <li><a href="{{ url('/') }}" class="transition hover:text-green-700">الرئيسية</a></li>
                            <li><a href="{{ route('map') }}" class="transition hover:text-green-700">الخريطة</a></li>
                            <li><a href="{{ route('states.show', $entry->state->slug) }}" class="transition hover:text-green-700">{{ $entry->state->name_ar }}</a></li>
                            <li><a href="{{ route('volunteer.create') }}" class="transition hover:text-green-700">المساهمة</a></li>
                            @if ($entry->panorama_path)
                                <li><a href="#panorama" class="transition hover:text-green-700">الجولة 360°</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
                <nav class="shrink-0 text-sm text-gray-600" aria-label="مسار التنقل">
                    <ol class="flex flex-wrap items-center gap-2 sm:justify-end">
                        <li><a href="{{ url('/') }}" class="hover:text-green-700">الرئيسية</a></li>
                        <li aria-hidden="true" class="text-gray-300">/</li>
                        <li><a href="{{ route('states.show', $entry->state->slug) }}" class="hover:text-green-700">{{ $entry->state->name_ar }}</a></li>
                        <li aria-hidden="true" class="text-gray-300">/</li>
                        <li class="font-bold text-gray-900" aria-current="page">{{ $entry->title }}</li>
                    </ol>
                </nav>
            </div>
        </header>

        <div class="relative overflow-hidden bg-white">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-green-50/80 via-white to-white"></div>
            <div class="relative z-10 mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="mb-4 flex flex-wrap gap-2 text-xs font-black">
                    <span class="rounded-full bg-green-100 px-3 py-1 text-green-800">{{ $entry->category?->name_ar ?? 'محتوى' }}</span>
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">{{ $entry->state->name_ar }}</span>
                    @if ($entry->locality)
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">{{ $entry->locality->name_ar }}</span>
                    @endif
                    @if ($entry->panorama_path)
                        <span class="rounded-full bg-emerald-600 px-3 py-1 text-white">360°</span>
                    @endif
                </div>

                <h1 class="max-w-4xl text-4xl font-black tracking-tight text-gray-900 sm:text-5xl">{{ $entry->title }}</h1>

                @if ($entry->excerpt)
                    <p class="mt-5 max-w-3xl text-lg leading-relaxed text-gray-600">{{ $entry->excerpt }}</p>
                @endif
            </div>
        </div>

        <main id="main-content">
            @if ($entry->panorama_path)
                <section id="panorama" class="scroll-mt-24 bg-gray-50 py-12" dir="rtl" aria-labelledby="panorama-heading">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <h2 id="panorama-heading" class="mb-6 text-3xl font-black text-gray-900">استكشف الموقع بزاوية 360 درجة</h2>
                        @if ($entry->panorama_is_compatible)
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
                                <img src="{{ $entry->panorama_url }}" alt="{{ $entry->title }}" class="h-auto w-full object-cover">
                                <div class="border-t border-amber-100 bg-amber-50 px-6 py-5 text-amber-950">
                                    <p class="text-lg font-black">الصورة المرفوعة ليست جولة 360 متوافقة بعد</p>
                                    <p class="mt-2 text-sm leading-7">
                                        يلزم رفع صورة بانوراما مسطّحة 360° تقريبًا
                                        <span class="font-black">2:1</span>
                                        (عرض تقريبًا ضعف الارتفاع) حتى يظهر المشهد التفاعلي بشكل صحيح.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            <section class="bg-white py-12" dir="rtl" aria-labelledby="content-heading">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">
                        <div class="lg:col-span-2">
                            <h2 id="content-heading" class="mb-6 text-2xl font-black text-gray-900">تفاصيل المحتوى</h2>
                            <div class="max-w-none space-y-4 text-lg leading-relaxed text-gray-700 [&_ul]:pr-6 [&_ul]:marker:text-green-600">
                                {!! $entry->content !!}
                            </div>
                        </div>

                        <aside class="h-fit rounded-3xl border border-gray-100 bg-gray-50 p-6">
                            <h3 class="mb-4 text-lg font-black text-gray-900">معلومات سريعة</h3>
                            <ul class="space-y-4 text-sm">
                                <li class="flex justify-between gap-4 border-b border-gray-100 pb-3"><span class="text-gray-500">الولاية</span> <strong class="text-gray-900">{{ $entry->state->name_ar }}</strong></li>
                                <li class="flex justify-between gap-4 border-b border-gray-100 pb-3"><span class="text-gray-500">المحلية</span> <strong class="text-gray-900">{{ $entry->locality?->name_ar ?? 'غير محددة' }}</strong></li>
                                <li class="flex justify-between gap-4 border-b border-gray-100 pb-3"><span class="text-gray-500">التصنيف</span> <strong class="text-gray-900">{{ $entry->category?->name_ar ?? 'غير محدد' }}</strong></li>
                                <li class="flex justify-between gap-4"><span class="text-gray-500">الحالة</span> <strong class="text-gray-900">{{ $entry->status }}</strong></li>
                            </ul>

                            <div class="mt-6 flex flex-col gap-3">
                                <a href="{{ route('states.show', $entry->state->slug) }}" class="rounded-xl bg-green-700 px-5 py-3 text-center text-sm font-black text-white transition hover:bg-green-800">العودة إلى صفحة الولاية</a>
                                @if ($entry->panorama_path)
                                    <a href="#panorama" class="rounded-xl border border-green-200 bg-white px-5 py-3 text-center text-sm font-black text-green-700 transition hover:bg-green-50">فتح الجولة الافتراضية</a>
                                @endif
                            </div>
                        </aside>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-gray-100 bg-gray-50 py-8" dir="rtl">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 text-center text-sm text-gray-500 sm:flex-row sm:text-right">
                <a href="{{ route('states.show', $entry->state->slug) }}" class="font-black text-green-800 hover:underline">العودة إلى {{ $entry->state->name_ar }}</a>
                <p>© {{ config('app.name', 'السودان الرقمي') }} - {{ $entry->title }}</p>
            </div>
        </footer>

        @if ($entry->panorama_path && $entry->panorama_is_compatible)
            @php
                $panoramaPathTrim = trim((string) $entry->panorama_path);
                // Pannellum يحمّل الصورة عبر XHR؛ يجب أن يكون المضيف مطابقًا لصفحة المتصفّح (ليس شرطًا APP_URL) حتى لا يُرفض الطلب (مثلاً localhost مقابل 127.0.0.1 أو منافذ مختلفة).
                if (\Illuminate\Support\Str::startsWith($panoramaPathTrim, ['http://', 'https://'])) {
                    $panoramaViewerUrl = $panoramaPathTrim;
                } else {
                    $published = asset('storage/' . ltrim($panoramaPathTrim, '/'));
                    $pathOnly = parse_url($published, PHP_URL_PATH);
                    $pathOnly = (is_string($pathOnly) && $pathOnly !== '')
                        ? '/'.trim($pathOnly, '/')
                        : '/storage/'.ltrim($panoramaPathTrim, '/');
                    if (! str_starts_with($pathOnly, '/')) {
                        $pathOnly = '/'.$pathOnly;
                    }
                    $panoramaViewerUrl = str_replace('\\', '/', rtrim(request()->root(), '/')).(str_starts_with($pathOnly, '/') ? $pathOnly : '/'.$pathOnly);
                }

                $pannellumStrings = [
                    'loadButtonLabel' => 'انقر لتحميل<br>البانوراما',
                    'loadingLabel' => 'جاري التحميل…',
                    'bylineLabel' => 'بواسطة %s',
                    'noPanoramaError' => 'لم يتم تحديد صورة بانوراما.',
                    'fileAccessError' => 'تعذّر الوصول إلى الملف %s.',
                    'malformedURLError' => 'رابط البانوراما غير صالح.',
                    'iOS8WebGLError' => 'بسبب قيود WebGL في iOS 8، قد لا تُعرض هذه البانوراما على جهازك.',
                    'genericWebGLError' => 'المتصفّح لا يوفّر دعم WebGL الكافي لعرض هذه البانوراما.',
                    'textureSizeError' => 'البانوراما كبيرة جدًا لهذا الجهاز (عرض %s بكسل، والحدّ المدعوم حوالي %s بكسل). جرّب تصغير الصورة أو جهازًا آخر.',
                    'unknownError' => 'خطأ غير معروف. راجع وحدة تحكم المطوّر (Console).',
                ];
            @endphp
            <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
            <script>
                (function () {
                    var el = document.getElementById('panorama-viewer');
                    var panoramaUrl = @json($panoramaViewerUrl);
                    var arabicStrings = @json($pannellumStrings);

                    if (! el || ! panoramaUrl) {
                        return;
                    }

                    function crossOriginForPanorama(url) {
                        try {
                            return new URL(url, window.location.href).origin !== window.location.origin ? 'anonymous' : null;
                        } catch (ignore) {
                            return 'anonymous';
                        }
                    }

                    function formatPanoramaInitError(e) {
                        if (! e || typeof e !== 'object') {
                            return String(e);
                        }
                        if ('type' in e) {
                            var parts = ['نوع الخطأ: ' + e.type];
                            if (e.type === 'config error') {
                                parts.push('تحقّق من type=equirectangular ومن صحة رابط الصورة وحجم الصورة وسياسات CORS');
                            }
                            if (e.width != null) {
                                parts.push('عرض الصورة ≈ ' + e.width + ' بكسل');
                            }
                            if (e.maxWidth != null) {
                                parts.push('الحدّ الأقصى المدعوم ≈ ' + e.maxWidth + ' بكسل');
                            }
                            return parts.join(' — ');
                        }
                        try {
                            return JSON.stringify(e);
                        } catch (ignore2) {
                            return String(e);
                        }
                    }

                    function hideIntroOverlay() {
                        var overlay = document.getElementById('pan-overlay');
                        if (overlay) {
                            overlay.style.opacity = '0';
                        }
                    }

                    function attachPannellumErrorLogging(viewerInstance) {
                        if (viewerInstance && typeof viewerInstance.on === 'function') {
                            viewerInstance.on('error', function (detail) {
                                console.error('[Pannellum] خطأ:', detail);
                            });
                        }
                        // بعد تحميل الصورة، بعض الأخطاء تُرمى من داخل Pannellum (va) ولا تُمسك بـ try/catch؛ نسجّلها لفترة قصيرة.
                        var ttl = Date.now() + 3e4;
                        var onThrow = function (ev) {
                            var err = ev && ev.error;
                            if (! ev || ! ev.filename || String(ev.filename).indexOf('pannellum') === -1) {
                                return;
                            }
                            if (! err || typeof err !== 'object' || ! ('type' in err)) {
                                return;
                            }
                            console.error('[Pannellum / WebGL]', err.type, err);
                            if (Date.now() > ttl) {
                                window.removeEventListener('error', onThrow);
                            }
                        };
                        window.addEventListener('error', onThrow);
                        setTimeout(function () {
                            window.removeEventListener('error', onThrow);
                        }, 3e4);
                    }

                    var co = crossOriginForPanorama(panoramaUrl);
                    var viewerConfig = {
                        type: String('equirectangular'),
                        panorama: panoramaUrl,
                        autoLoad: true,
                        autoRotate: -1,
                        showControls: true,
                        compass: true,
                        title: @json($entry->title),
                        author: 'دليل السودان الرقمي',
                        strings: arabicStrings,
                    };
                    if (co) {
                        viewerConfig.crossOrigin = co;
                    }

                    try {
                        var viewer = pannellum.viewer('panorama-viewer', viewerConfig);
                        attachPannellumErrorLogging(viewer);
                    } catch (e) {
                        var msg = formatPanoramaInitError(e);
                        el.innerHTML =
                            '<div class="flex h-full items-center justify-center bg-gray-900 px-4 text-center text-sm text-white">' +
                            '<p>تعذّر تشغيل الجولة 360°.</p>' +
                            '<p class="mt-2 text-xs opacity-90">' + msg + '</p>' +
                            '<p class="mt-3 max-w-xl text-[11px] leading-relaxed opacity-75">إن استمر الخطأ: تأكد من تنفيذ <code class=\"rounded bg-white/10 px-1\">php artisan storage:link</code>' +
                            ' وافتح رابط الصورة في تبويب جديد، واختبر صورة أوضح/smaller بدون عنوان APP_URL مختلف عن عنوان المتصفّح.</p></div>';
                        console.error('[Pannellum] فشل تهيئة المشغّل:', e);
                    }

                    el.addEventListener('mousedown', hideIntroOverlay);
                    el.addEventListener('touchstart', hideIntroOverlay, { passive: true });
                })();
            </script>
        @endif
    </body>
</html>
