@php
    $currentLocale = $currentLocale ?? app()->getLocale();
    $currentDirection = $currentDirection ?? 'rtl';

    $navigationItems = [
        ['label' => 'الرئيسية', 'route' => 'home', 'match' => 'home'],
        ['label' => 'الخريطة', 'route' => 'map', 'match' => 'map'],
        ['label' => 'الاستثمار', 'route' => 'investment.index', 'match' => 'investment.*'],
        ['label' => 'الحكايات', 'route' => 'stories.index', 'match' => 'stories.*'],
        ['label' => 'عن المشروع', 'route' => 'about', 'match' => 'about'],
        ['label' => 'تواصل', 'route' => 'contact', 'match' => 'contact'],
    ];
@endphp

<style>
    body > header:not(.site-header-shell) {
        display: none !important;
    }

    body[data-mobile-nav-open="true"] {
        overflow: hidden;
    }
</style>

<header class="site-header-shell mobile-header sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/85" dir="{{ $currentDirection }}">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-[82px] items-center justify-between gap-4 py-[3px]">
            <a href="{{ route('home') }}" class="shrink-0 text-lg font-black text-gray-900 md:text-xl">
                السودان الرقمي
            </a>

            <nav class="hidden min-w-0 flex-1 justify-center lg:flex" aria-label="أقسام المنصة">
                <ul class="flex flex-wrap items-center justify-center gap-2 text-sm font-black text-gray-600">
                    @foreach ($navigationItems as $item)
                        <li>
                            <a
                                href="{{ route($item['route']) }}"
                                class="inline-flex rounded-full px-4 py-2 transition {{ request()->routeIs($item['match']) ? 'bg-green-50 text-green-800 ring-1 ring-green-100' : 'hover:bg-gray-50 hover:text-green-700' }}"
                            >
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="hidden shrink-0 items-center gap-3 lg:flex">
                <div class="px-1 py-2">
                    <select
                        class="min-w-[132px] appearance-none border-0 bg-transparent px-3 py-2 text-xs font-black text-gray-700 outline-none ring-0 transition focus:border-0 focus:outline-none focus:ring-0"
                        aria-label="اختيار اللغة"
                        onchange="if (this.value) window.location.href = this.value;"
                    >
                        @foreach (($supportedLocales ?? []) as $localeCode => $localeConfig)
                            <option value="{{ route('language.switch', $localeCode) }}" {{ $currentLocale === $localeCode ? 'selected' : '' }}>
                                {{ $localeConfig['native'] ?? strtoupper($localeCode) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <a href="{{ route('contributor.login') }}" class="rounded-full px-4 py-2 text-sm font-black text-gray-700 transition hover:bg-gray-50">
                    دخول
                </a>
                <a href="{{ route('volunteer.create') }}" class="rounded-full bg-green-700 px-5 py-2.5 text-sm font-black text-white shadow-sm transition hover:bg-green-800">
                    انضم للمساهمة
                </a>
            </div>

            <div class="flex shrink-0 items-center gap-2 lg:hidden">
                <a href="{{ route('contributor.login') }}" class="rounded-2xl border border-green-200 bg-green-50 px-4 py-2.5 text-sm font-black text-green-800 shadow-sm transition hover:bg-green-100">
                    دخول
                </a>

                <button
                    type="button"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-gray-200 bg-white text-gray-700 shadow-sm transition hover:bg-gray-50"
                    aria-expanded="false"
                    aria-controls="mobile-site-menu"
                    aria-label="فتح القائمة"
                    data-mobile-nav-toggle
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true" data-mobile-nav-icon="closed">
                        <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>
                    </svg>
                    <svg class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true" data-mobile-nav-icon="open">
                        <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div
        id="mobile-site-menu"
        class="hidden border-t border-gray-200 bg-white/98 shadow-2xl lg:hidden"
        data-mobile-nav-panel
    >
        <div class="mx-auto max-w-7xl px-4 pb-5 pt-4 sm:px-6">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-black text-gray-900">القائمة الرئيسية</p>
                    <p class="mt-1 text-xs font-bold text-gray-500">تنقل واضح داخل المنصة</p>
                </div>
                <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-black text-green-700">MENU</span>
            </div>

            <nav aria-label="القائمة الرئيسية">
                <ul class="grid gap-2.5 text-sm font-black text-gray-700">
                    @foreach ($navigationItems as $item)
                        <li>
                            <a
                                href="{{ route($item['route']) }}"
                                class="block rounded-2xl border border-transparent px-4 py-3 transition {{ request()->routeIs($item['match']) ? 'border-green-100 bg-green-50 text-green-800' : 'bg-gray-50 hover:border-green-100 hover:bg-green-50' }}"
                            >
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="mt-4 grid gap-3">
                <a href="{{ route('volunteer.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-green-700 px-4 py-3 text-sm font-black text-white shadow-sm transition hover:bg-green-800">
                    انضم للمساهمة
                </a>

                <div class="px-1 py-1">
                    <select
                        class="w-full appearance-none border-0 bg-transparent px-3 py-3 text-sm font-black text-gray-700 outline-none ring-0 transition focus:border-0 focus:outline-none focus:ring-0"
                        aria-label="اختيار اللغة"
                        onchange="if (this.value) window.location.href = this.value;"
                    >
                        @foreach (($supportedLocales ?? []) as $localeCode => $localeConfig)
                            <option value="{{ route('language.switch', $localeCode) }}" {{ $currentLocale === $localeCode ? 'selected' : '' }}>
                                {{ $localeConfig['native'] ?? strtoupper($localeCode) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    (() => {
        const toggle = document.querySelector('[data-mobile-nav-toggle]');
        const panel = document.querySelector('[data-mobile-nav-panel]');

        if (!toggle || !panel) {
            return;
        }

        const closedIcon = toggle.querySelector('[data-mobile-nav-icon="closed"]');
        const openIcon = toggle.querySelector('[data-mobile-nav-icon="open"]');

        const setMenuState = (isOpen) => {
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            document.body.dataset.mobileNavOpen = isOpen ? 'true' : 'false';
            panel.classList.toggle('hidden', !isOpen);
            closedIcon?.classList.toggle('hidden', isOpen);
            openIcon?.classList.toggle('hidden', !isOpen);
        };

        setMenuState(false);

        toggle.addEventListener('click', () => {
            setMenuState(toggle.getAttribute('aria-expanded') !== 'true');
        });

        panel.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => setMenuState(false));
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                setMenuState(false);
            }
        });
    })();
</script>
