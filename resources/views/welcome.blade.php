<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>صندوق الزكاة سرت | البوابة الرسمية</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-['Cairo'] selection:bg-emerald-600 selection:text-white" x-data="landingApp()">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-emerald-700 to-emerald-500 text-white flex items-center justify-center font-black text-xl shadow-md shadow-emerald-700/20">
                    ز
                </div>
                <div>
                    <h1 class="text-xl font-black text-slate-900 tracking-tight leading-none">صندوق الزكاة</h1>
                    <span class="text-xs font-semibold text-emerald-700">فرع سرت - الهيئة العامة للأوقاف</span>
                </div>
            </div>

            <nav class="hidden md:flex items-center gap-8 font-bold text-sm text-slate-600">
                <a href="#about" class="hover:text-emerald-700 transition">عن الصندوق</a>
                <a href="#services" class="hover:text-emerald-700 transition">مصارف الزكاة ومشاريعنا</a>
                <a href="#stats" class="hover:text-emerald-700 transition">الشفافية والأرقام</a>
                <a href="#contact" class="hover:text-emerald-700 transition">تواصل معنا</a>
            </nav>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-bold shadow-md shadow-emerald-700/20 transition">
                            بوابة المستفيد
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-slate-700 hover:bg-slate-100 text-sm font-bold transition">
                            دخول المستفيد
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="hidden sm:inline-block px-4 py-2 rounded-xl border border-slate-300 hover:border-emerald-700 hover:text-emerald-700 text-slate-700 text-sm font-bold transition">
                                فتح ملف جديد
                            </a>
                        @endif
                    @endauth
                @endif
                <button @click="calculatorOpen = true" class="hidden lg:inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold shadow-sm transition">
                    <span>حساب الزكاة</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-16 pb-24 lg:pt-24 lg:pb-32 bg-gradient-to-b from-white via-slate-50 to-emerald-50/40">
        <div class="absolute inset-0 pointer-events-none opacity-25 [background-image:radial-gradient(#059669_0.75px,transparent_0.75px)] [background-size:16px_16px]"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 space-y-6 text-center lg:text-right">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">
                        <span>منظومة رقمية موحدة للتحصيل والصرف العادل</span>
                    </div>

                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 leading-tight">
                        أداء الفريضة، <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-l from-emerald-800 to-emerald-600">وصول الأمانة لمستحقيها بسرت</span>
                    </h2>

                    <p class="text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        المنصة الإلكترونية الرسمية لصندوق الزكاة ببلدية سرت. نيسر على المزكّين حساب زكواتهم شرعاً، ونمكّن الأسر المستحقة من تقديم وتجديد ملفاتهم وحصولهم على الدعم بكرامة وشفافية كاملة.
                    </p>

                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                        <button @click="calculatorOpen = true" class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-700 to-emerald-600 hover:from-emerald-800 hover:to-emerald-700 text-white font-bold text-base shadow-lg shadow-emerald-700/25 transition transform hover:-translate-y-0.5 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <span>احسب زكاتك الآن</span>
                        </button>
                        
                        <a href="{{ route('login') }}" class="px-7 py-3.5 rounded-2xl bg-white hover:bg-slate-100 text-slate-800 font-bold text-base border border-slate-300 shadow-xs transition">
                            بوابة المستفيدين والتجديد
                        </a>
                    </div>

                    <div class="pt-6 grid grid-cols-3 gap-6 border-t border-slate-200/80 max-w-lg mx-auto lg:mx-0 text-right">
                        <div>
                            <div class="text-2xl font-black text-slate-900">100%</div>
                            <div class="text-xs text-slate-500 font-semibold">مطابقة للشريعة الإسلامية</div>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-slate-900">16+</div>
                            <div class="text-xs text-slate-500 font-semibold">جدول بيانات رقابي متكامل</div>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-slate-900">فوري</div>
                            <div class="text-xs text-slate-500 font-semibold">حساب النصاب والأنصبة</div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md bg-white rounded-3xl p-6 shadow-2xl shadow-slate-300/60 border border-slate-200">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md">خدمات فورية</span>
                                <h3 class="font-extrabold text-slate-900 text-lg mt-1">نافذة الخدمات السريعة</h3>
                            </div>
                            <div class="w-9 h-9 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                        </div>

                        <div class="space-y-4 pt-5">
                            <div @click="calculatorOpen = true; calcType = 'CASH_WEALTH'" class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200 hover:border-emerald-300 transition cursor-pointer flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">💰</div>
                                    <div>
                                        <h4 class="font-bold text-sm text-slate-900 group-hover:text-emerald-800">زكاة المال والمدخرات</h4>
                                        <p class="text-xs text-slate-500">حساب نصاب 85 جم ذهب ونسبة 2.5%</p>
                                    </div>
                                </div>
                                <span class="text-emerald-700 text-sm font-bold">←</span>
                            </div>

                            <div @click="calculatorOpen = true; calcType = 'LIVESTOCK'" class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200 hover:border-emerald-300 transition cursor-pointer flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">🐑</div>
                                    <div>
                                        <h4 class="font-bold text-sm text-slate-900 group-hover:text-emerald-800">زكاة الأنعام والمواشي</h4>
                                        <p class="text-xs text-slate-500">أنصبة الأغنام والماشية شرعاً</p>
                                    </div>
                                </div>
                                <span class="text-emerald-700 text-sm font-bold">←</span>
                            </div>

                            <div @click="calculatorOpen = true; calcType = 'CROPS_AGRICULTURE'" class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200 hover:border-emerald-300 transition cursor-pointer flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-yellow-100 text-yellow-700 flex items-center justify-center font-bold">🌾</div>
                                    <div>
                                        <h4 class="font-bold text-sm text-slate-900 group-hover:text-emerald-800">زكاة الزروع والثمار</h4>
                                        <p class="text-xs text-slate-500">حساب 5 أوسق والري بالمطر أو الآلات</p>
                                    </div>
                                </div>
                                <span class="text-emerald-700 text-sm font-bold">←</span>
                            </div>

                            <div class="p-4 rounded-2xl bg-emerald-700 text-white flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-sm">مستفيد مسجل في سرت؟</h4>
                                    <p class="text-xs text-emerald-100 mt-0.5">جدد ملفك السنوي إلكترونياً دون الحاجة للحضور</p>
                                </div>
                                <a href="{{ route('login') }}" class="px-3.5 py-1.5 bg-white text-emerald-800 text-xs font-extrabold rounded-lg hover:bg-emerald-50 transition">دخول</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services / Pillars Section -->
    <section id="services" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-emerald-700 font-extrabold text-sm uppercase tracking-wide">مصارف الخير في سرت</span>
                <h3 class="text-3xl font-black text-slate-900 mt-2">مشاريع الصندوق ومسارات التوزيع المعتمدة</h3>
                <p class="text-slate-600 mt-3 text-base">توجه أموال الزكاة والصدقات بدقة وفقاً للمصارف الشرعية المنصوص عليها، وتحت إشراف مباشر من باحثين اجتماعيين مختصين.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-400 hover:shadow-lg transition">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-black text-2xl mb-4">🤝</div>
                    <h4 class="font-bold text-lg text-slate-900 mb-2">كفالة الأسر والأيتام</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">مخصصات شهرية ثابتة للأرامل والأيتام والأسر المعوزة في نطاق بلدية سرت.</p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-400 hover:shadow-lg transition">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-black text-2xl mb-4">📦</div>
                    <h4 class="font-bold text-lg text-slate-900 mb-2">السلال الغذائية والمواسم</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">توزيع السلال التموينية ومساعدات شهر رمضان المبارك وكسوة وعيدية الأيتام.</p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-400 hover:shadow-lg transition">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-black text-2xl mb-4">🩺</div>
                    <h4 class="font-bold text-lg text-slate-900 mb-2">الإعانة العلاجية والدوائية</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">دعم العمليات الجراحية العاجلة وتوفير الأدوية الدورية لأصحاب الأمراض المزمنة.</p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-400 hover:shadow-lg transition">
                    <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center font-black text-2xl mb-4">⚖️</div>
                    <h4 class="font-bold text-lg text-slate-900 mb-2">تفريج الكرب وسداد الغارمين</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">دراسة حالات التعثر والديون الطارئة لغير القادرين لإعادة الاستقرار للأسر.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats & Trust Section -->
    <section id="stats" class="py-16 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-y md:divide-y-0 md:divide-x md:divide-x-reverse divide-slate-800">
                <div class="pt-4 md:pt-0">
                    <div class="text-4xl lg:text-5xl font-black text-emerald-400">100%</div>
                    <div class="text-sm text-slate-400 mt-2 font-semibold">أمانة وتوثيق إلكتروني</div>
                </div>
                <div class="pt-4 md:pt-0">
                    <div class="text-4xl lg:text-5xl font-black text-emerald-400">سنوي</div>
                    <div class="text-sm text-slate-400 mt-2 font-semibold">تجديد وبحث دوري للملفات</div>
                </div>
                <div class="pt-4 md:pt-0">
                    <div class="text-4xl lg:text-5xl font-black text-emerald-400">سرت</div>
                    <div class="text-sm text-slate-400 mt-2 font-semibold">تغطية لكافة المحلات والأحياء</div>
                </div>
                <div class="pt-4 md:pt-0">
                    <div class="text-4xl lg:text-5xl font-black text-emerald-400">سري</div>
                    <div class="text-sm text-slate-400 mt-2 font-semibold">حفظ كامل لخصوصية وكرامة الأسر</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-white border-t border-slate-200 py-12 text-sm text-slate-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-700 text-white flex items-center justify-center font-bold text-sm">
                    ز
                </div>
                <div>
                    <p class="font-bold text-slate-800">صندوق الزكاة - فرع سرت</p>
                    <p class="text-xs text-slate-500">مشروع التخرج الأكاديمي لنظم إدارة وتوزيع الزكاة</p>
                </div>
            </div>

            <div class="flex items-center gap-6 font-semibold">
                <a href="{{ route('calculator') }}" class="hover:text-emerald-700">صفحة الحاسبة المستقلة</a>
                <a href="{{ route('login') }}" class="hover:text-emerald-700">دخول المستفيد</a>
            </div>

            <div class="text-xs text-slate-500">
                جميع الحقوق محفوظة &copy; {{ date('Y') }}
            </div>
        </div>
    </footer>

    <!-- Persistent Floating Widget Button -->
    <div class="fixed bottom-6 left-6 z-50">
        <button @click="calculatorOpen = true" 
                class="group flex items-center gap-3 px-5 py-3.5 rounded-full bg-gradient-to-r from-emerald-700 to-emerald-600 hover:from-emerald-800 hover:to-emerald-700 text-white font-black shadow-xl shadow-emerald-900/30 hover:shadow-2xl transition transform hover:scale-105 active:scale-95 focus:outline-hidden">
            <span class="flex h-3 w-3 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-300"></span>
            </span>
            <span class="text-lg">💰</span>
            <span class="text-sm tracking-wide">حاسبة الزكاة الذكية</span>
        </button>
    </div>

    <!-- Floating Calculator Modal / Widget Popup -->
    <div x-show="calculatorOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4" 
         style="display: none;" 
         @keydown.escape.window="calculatorOpen = false">
        
        <div @click.away="calculatorOpen = false" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-6 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-6 sm:scale-95"
             class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl border border-slate-200 overflow-hidden relative">

            <!-- Modal Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-emerald-800 to-emerald-700 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-xl">🧮</div>
                    <div>
                        <h3 class="font-extrabold text-base leading-tight">حاسبة الزكاة الشرعية الفورية</h3>
                        <p class="text-xs text-emerald-100">احسب زكاتك وفق الضوابط الفقهية المعتمدة</p>
                    </div>
                </div>
                <button @click="calculatorOpen = false" class="text-emerald-100 hover:text-white rounded-lg p-1 text-2xl font-bold leading-none">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Type Selection Tabs -->
                <div class="grid grid-cols-3 gap-2 mb-6">
                    <button type="button" @click="calcType = 'CASH_WEALTH'; result = null;" 
                            :class="calcType === 'CASH_WEALTH' ? 'bg-emerald-50 border-emerald-600 text-emerald-900 font-black' : 'border-slate-200 text-slate-600 hover:bg-slate-50 font-bold'"
                            class="border-2 rounded-xl py-2.5 px-3 text-xs sm:text-sm text-center transition">
                        زكاة المال والذهب
                    </button>
                    <button type="button" @click="calcType = 'LIVESTOCK'; result = null;" 
                            :class="calcType === 'LIVESTOCK' ? 'bg-emerald-50 border-emerald-600 text-emerald-900 font-black' : 'border-slate-200 text-slate-600 hover:bg-slate-50 font-bold'"
                            class="border-2 rounded-xl py-2.5 px-3 text-xs sm:text-sm text-center transition">
                        زكاة الأنعام
                    </button>
                    <button type="button" @click="calcType = 'CROPS_AGRICULTURE'; result = null;" 
                            :class="calcType === 'CROPS_AGRICULTURE' ? 'bg-emerald-50 border-emerald-600 text-emerald-900 font-black' : 'border-slate-200 text-slate-600 hover:bg-slate-50 font-bold'"
                            class="border-2 rounded-xl py-2.5 px-3 text-xs sm:text-sm text-center transition">
                        زكاة الزروع والثمار
                    </button>
                </div>

                <!-- Calculation Form -->
                <form @submit.prevent="runCalculation()" class="space-y-4">
                    <!-- Cash / Wealth -->
                    <template x-if="calcType === 'CASH_WEALTH'">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">المبلغ النقدي المدخر (دينار ليبي)</label>
                                <input type="number" step="any" x-model="form.amount" required placeholder="مثال: 50000" class="w-full border-slate-300 rounded-xl text-sm focus:ring-emerald-500 focus:border-emerald-500 py-2.5">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">سعر جرام الذهب عيار 24 اليوم (لحساب النصاب 85 جم)</label>
                                <input type="number" step="any" x-model="form.gold_price_per_gram" required class="w-full border-slate-300 bg-slate-50 rounded-xl text-sm focus:ring-emerald-500 focus:border-emerald-500 py-2.5">
                            </div>
                        </div>
                    </template>

                    <!-- Livestock -->
                    <template x-if="calcType === 'LIVESTOCK'">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">صنف الماشية</label>
                                <select x-model="form.animal_type" class="w-full border-slate-300 rounded-xl text-sm focus:ring-emerald-500 focus:border-emerald-500 py-2.5">
                                    <option value="sheep">الغنم (الضأن والماعز) - النصاب يبدأ من 40 شاة</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">إجمالي عدد الرؤوس</label>
                                <input type="number" min="0" x-model="form.count" required placeholder="مثال: 120" class="w-full border-slate-300 rounded-xl text-sm focus:ring-emerald-500 focus:border-emerald-500 py-2.5">
                            </div>
                        </div>
                    </template>

                    <!-- Crops -->
                    <template x-if="calcType === 'CROPS_AGRICULTURE'">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">وزن المحصول الصافي (بالكيلوجرام)</label>
                                <input type="number" step="any" min="0" x-model="form.kilograms" required placeholder="النصاب 653 كجم تقريباً" class="w-full border-slate-300 rounded-xl text-sm focus:ring-emerald-500 focus:border-emerald-500 py-2.5">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">طريقة الري والسقاية</label>
                                <select x-model="form.is_irrigated" class="w-full border-slate-300 rounded-xl text-sm focus:ring-emerald-500 focus:border-emerald-500 py-2.5">
                                    <option value="0">سقي بماء المطر والأنهار (العشر - 10%)</option>
                                    <option value="1">سقي بالآلات والتكلفة والمضخات (نصف العشر - 5%)</option>
                                </select>
                            </div>
                        </div>
                    </template>

                    <div x-show="errorMessage" x-text="errorMessage" class="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold" style="display: none;"></div>

                    <div class="pt-2">
                        <button type="submit" :disabled="loading" 
                                class="w-full py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold text-sm shadow-md shadow-emerald-800/20 transition disabled:opacity-50">
                            <span x-show="!loading">احسب الزكاة الشرعية</span>
                            <span x-show="loading">جاري الحساب...</span>
                        </button>
                    </div>
                </form>

                <!-- Result Box -->
                <div x-show="result" class="mt-6 p-4 rounded-2xl bg-slate-50 border border-slate-200" style="display: none;">
                    <h4 class="font-extrabold text-slate-900 text-sm mb-3">النتيجة الشرعية:</h4>
                    
                    <div x-show="!result?.is_eligible" class="p-3 bg-emerald-100/70 border border-emerald-300 rounded-xl text-emerald-900 font-bold text-xs leading-relaxed">
                        القدر المدخل لم يبلغ النصاب الشرعي المحدد، فلا تجب فيه الزكاة.
                    </div>

                    <div x-show="result?.is_eligible" class="space-y-2.5 text-xs sm:text-sm">
                        <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-slate-200">
                            <span class="text-slate-600 font-bold">القدر الواجب إخراجه:</span>
                            <span class="font-black text-rose-600 text-base" x-text="result?.zakat_due + ' ' + (result?.currency || result?.unit)"></span>
                        </div>
                        <div class="flex items-center justify-between px-3 py-1 text-slate-500">
                            <span>حالة النصاب:</span>
                            <span class="font-bold text-emerald-700">بلغ النصاب الشرعي</span>
                        </div>
                        <div class="flex items-center justify-between px-3 py-1 text-slate-500">
                            <span>البيان الفقهي:</span>
                            <span class="font-semibold text-slate-800" x-text="result?.breakdown"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine App State -->
    <script>
        function landingApp() {
            return {
                calculatorOpen: false,
                calcType: 'CASH_WEALTH',
                loading: false,
                errorMessage: null,
                result: null,
                form: {
                    amount: null,
                    gold_price_per_gram: 350,
                    animal_type: 'sheep',
                    count: null,
                    kilograms: null,
                    is_irrigated: "0"
                },

                async runCalculation() {
                    this.loading = true;
                    this.errorMessage = null;
                    this.result = null;

                    try {
                        const payload = {
                            calculation_type: this.calcType,
                            amount: this.form.amount,
                            gold_price_per_gram: this.form.gold_price_per_gram,
                            animal_type: this.form.animal_type,
                            count: this.form.count,
                            kilograms: this.form.kilograms,
                            is_irrigated: this.form.is_irrigated === "1"
                        };

                        const response = await axios.post('/api/zakat/calculate', payload);
                        this.result = response.data.results;
                    } catch (err) {
                        this.errorMessage = 'تعذر إجراء الحساب. يرجى التأكد من صحة المدخلات.';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</body>
</html>