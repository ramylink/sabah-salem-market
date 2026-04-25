<footer class="bg-warm-900 text-warm-300 mt-16">
    <div class="page-container py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand -->
            <div class="md:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-primary-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-xl">ص</span>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-lg">صباح السالم</h3>
                        <p class="text-sm text-warm-400">جمعية تعاونية</p>
                    </div>
                </div>
                <p class="text-sm leading-relaxed">تسوق أونلاين بسهولة من جمعية صباح السالم التعاونية. خضروات طازجة، لحوم، ألبان، ومستلزمات منزلية بأفضل الأسعار.</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold mb-4">روابط سريعة</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('products.index') }}" wire:navigate class="hover:text-primary-400 transition-colors">جميع المنتجات</a></li>
                    <li><a href="{{ route('products.index') }}?on_sale=1" wire:navigate class="hover:text-primary-400 transition-colors">عروض خاصة</a></li>
                    <li><a href="#" class="hover:text-primary-400 transition-colors">الأكثر مبيعاً</a></li>
                    <li><a href="#" class="hover:text-primary-400 transition-colors">منتجات جديدة</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h4 class="text-white font-semibold mb-4">الدعم</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-primary-400 transition-colors">مركز المساعدة</a></li>
                    <li><a href="#" class="hover:text-primary-400 transition-colors">سياسة الإرجاع</a></li>
                    <li><a href="#" class="hover:text-primary-400 transition-colors">شروط الاستخدام</a></li>
                    <li><a href="#" class="hover:text-primary-400 transition-colors">سياسة الخصوصية</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-white font-semibold mb-4">تواصل معنا</h4>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        1800080
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        info@sabah-salem.com
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        صباح السالم، الكويت
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-warm-800 mt-8 pt-8 text-center text-sm text-warm-500">
            <p>جميع الحقوق محفوظة © {{ date('Y') }} جمعية صباح السالم التعاونية</p>
        </div>
    </div>
</footer>
