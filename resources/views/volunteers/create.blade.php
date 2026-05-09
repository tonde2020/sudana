<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>انضم للمساهمة - {{ config('app.name', 'السودان الرقمي') }}</title>
        <meta name="description" content="صفحة الانضمام إلى منصة السودان الرقمي للمساهمة في التوثيق والخدمات والمحتوى الوطني.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            body { font-family: 'Cairo', ui-sans-serif, system-ui, sans-serif; }
        </style>
    </head>
    <body class="min-h-screen bg-[#f8fbf8] text-gray-900 antialiased">
        @include('partials.mobile-header')
        <header class="border-b border-emerald-100 bg-white/90 backdrop-blur" dir="rtl">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-3 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                <div class="flex items-center justify-between gap-3">
                    <a href="{{ route('home') }}" class="text-lg font-black text-emerald-900">السودان الرقمي</a>
                    <div class="flex items-center gap-2 lg:hidden">
                        <a href="{{ route('map') }}" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-black text-emerald-800">الخريطة</a>
                        <a href="{{ route('contributor.login') }}" class="rounded-xl bg-emerald-700 px-4 py-2 text-sm font-black text-white">دخول المساهم</a>
                    </div>
                </div>
                <nav class="overflow-x-auto [-webkit-overflow-scrolling:touch]" aria-label="التنقل">
                    <ul class="flex items-center gap-5 whitespace-nowrap text-sm font-black text-gray-600">
                        <li><a href="{{ route('home') }}" class="transition hover:text-emerald-700">الرئيسية</a></li>
                        <li><a href="{{ route('map') }}" class="transition hover:text-emerald-700">الخريطة</a></li>
                        <li><a href="{{ route('home') }}#states" class="transition hover:text-emerald-700">الولايات</a></li>
                        <li><span class="text-emerald-700">المساهمة</span></li>
                    </ul>
                </nav>
                <a href="{{ route('contributor.login') }}" class="hidden rounded-xl bg-emerald-700 px-5 py-2.5 text-sm font-black text-white transition hover:bg-emerald-800 lg:inline-flex">دخول المساهم</a>
            </div>
        </header>

        <main class="py-10 sm:py-14" dir="rtl">
            <div class="mx-auto grid max-w-[92rem] items-start gap-8 px-4 sm:px-6 xl:grid-cols-[0.78fr_minmax(0,1.22fr)] xl:px-8">
                <section class="rounded-[2rem] bg-gradient-to-br from-emerald-900 via-emerald-800 to-green-700 p-8 text-white shadow-xl sm:p-10 xl:sticky xl:top-24">
                    <span class="inline-flex rounded-full bg-white/15 px-4 py-2 text-xs font-black text-white ring-1 ring-white/25">برنامج المساهمين</span>
                    <h1 class="mt-6 text-3xl font-black leading-tight sm:text-4xl">انضم إلى منصة السودان الرقمي كمساهم وراصد لولايتك</h1>
                    <p class="mt-5 text-sm leading-8 text-emerald-50 sm:text-base">
                        نسعى لبناء مرجع وطني موثوق يخدم المواطن والباحث والمستثمر. دورك يبدأ من معرفة محيطك المحلي وتوثيقه بجودة ومسؤولية.
                    </p>

                    <div class="mt-8 grid gap-4">
                        <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/15">
                            <p class="font-black">كيف تتم المشاركة؟</p>
                            <p class="mt-2 text-sm leading-7 text-emerald-50">تسجل بياناتك، يراجع فريق الإدارة الطلب، ثم يتم تفعيل حسابك وإسناد الولاية المناسبة لك داخل المنصة.</p>
                        </div>
                        <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/15">
                            <p class="font-black">ما نوع المساهمة؟</p>
                            <p class="mt-2 text-sm leading-7 text-emerald-50">توثيق المعالم والشخصيات، تحديث الخدمات، إثراء فرص الاستثمار، وإرسال صور ومحتوى عالي الجودة.</p>
                        </div>
                        <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/15">
                            <p class="font-black">ما بعد القبول</p>
                            <p class="mt-2 text-sm leading-7 text-emerald-50">تدخل إلى لوحة المساهمة وتبدأ بإضافة البيانات التي تخضع للمراجعة قبل النشر النهائي.</p>
                        </div>
                    </div>
                </section>

                <section class="rounded-[2rem] border border-emerald-100 bg-white p-6 shadow-sm sm:p-8 xl:p-10">
                    @if (session('success'))
                        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-900">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800">
                            <p class="mb-2 font-black">يرجى مراجعة الحقول التالية:</p>
                            <ul class="space-y-1 pr-4">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-8">
                        <h2 class="text-2xl font-black text-gray-900">طلب الانضمام إلى المنصة</h2>
                        <p class="mt-3 text-sm leading-7 text-gray-600">أدخل بياناتك بعناية. هذه الصفحة مخصصة لطلب المشاركة والمساهمة في التوثيق الوطني داخل المنصة.</p>
                        <p class="mt-3 text-sm font-bold text-emerald-800">
                            لديك حساب مساهم بالفعل؟
                            <a href="{{ route('contributor.login') }}" class="underline decoration-emerald-300 underline-offset-4 hover:text-emerald-900">ادخل إلى لوحة المساهم</a>
                        </p>
                    </div>

                    <form action="{{ route('volunteer.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="name" class="mb-2 block text-sm font-black text-gray-800">الاسم الكامل</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-right focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="أدخل اسمك الثلاثي">
                            </div>

                            <div>
                                <label for="email" class="mb-2 block text-sm font-black text-gray-800">البريد الإلكتروني</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-right focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="name@example.com">
                            </div>

                            <div>
                                <label for="phone" class="mb-2 block text-sm font-black text-gray-800">رقم الهاتف أو واتساب</label>
                                <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-right focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="09xxxxxxxx">
                            </div>
                        </div>

                        <div>
                            <label for="state_id" class="mb-2 block text-sm font-black text-gray-800">الولاية المستهدفة</label>
                            <select id="state_id" name="state_id" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-right focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                <option value="">اختر الولاية</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" @selected(old('state_id') == $state->id)>{{ $state->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-3 block text-sm font-black text-gray-800">مجالات المساهمة</label>
                            <div class="grid gap-3 sm:grid-cols-2">
                                @foreach ($skills as $key => $label)
                                    <label class="flex items-center gap-3 rounded-2xl border border-gray-200 bg-gray-50 px-4 py-4 transition hover:border-emerald-300 hover:bg-emerald-50">
                                        <input type="checkbox" name="skills[]" value="{{ $key }}" @checked(in_array($key, old('skills', []), true)) class="h-5 w-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                        <span class="text-sm font-bold text-gray-700">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label for="motivation" class="mb-2 block text-sm font-black text-gray-800">نبذة عنك ودافعك للمساهمة</label>
                            <textarea id="motivation" name="motivation" rows="5" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-right leading-8 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="اكتب بإيجاز عن خبرتك أو علاقتك بالولاية، وما الذي تنوي المساهمة به داخل المنصة.">{{ old('motivation') }}</textarea>
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <label for="password" class="mb-2 block text-sm font-black text-gray-800">كلمة المرور</label>
                                <input id="password" name="password" type="password" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-right focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200">
                            </div>
                            <div>
                                <label for="password_confirmation" class="mb-2 block text-sm font-black text-gray-800">تأكيد كلمة المرور</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-right focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200">
                            </div>
                        </div>

                        <div class="rounded-[1.75rem] border border-emerald-200 bg-emerald-50 p-5">
                            <h3 class="mb-3 text-base font-black text-emerald-900">ميثاق المساهمة الوطنية</h3>
                            <div class="space-y-3 text-sm leading-7 text-emerald-900">
                                <p>بصفتي مساهماً في منصة السودان الرقمي، أتعهد بالأمانة في نقل المعلومات، والتحري في صحة البيانات، واحترام حقوق الآخرين، وتغليب المصلحة الوطنية في كل ما أنشره أو أراجعه.</p>
                                <ul class="space-y-1 pr-4">
                                    <li>• ألتزم بالدقة وعدم نشر معلومات مضللة أو مثيرة للكراهية.</li>
                                    <li>• أحترم الصور والمصادر والحقوق الفكرية.</li>
                                    <li>• أساهم بروح بناءة تعكس صورة السودان كما يجب أن تُروى.</li>
                                </ul>
                            </div>
                        </div>

                        <label class="flex items-start gap-3 rounded-2xl border border-gray-200 bg-gray-50 px-4 py-4">
                            <input type="checkbox" name="agreed_to_manifesto" value="1" @checked(old('agreed_to_manifesto')) class="mt-1 h-5 w-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm font-bold leading-7 text-gray-700">أقر بأنني قرأت ميثاق المساهمة، وأوافق على العمل وفق مبادئه داخل المنصة.</span>
                        </label>

                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-700 px-6 py-4 text-center text-lg font-black text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-emerald-800">
                            إرسال طلب الانضمام
                        </button>
                    </form>
                </section>
            </div>
        </main>
    </body>
</html>
