<header class="sticky-header">
    <div class="page-container">
        <div class="flex items-center gap-3 py-3">
            <!-- Logo -->
            <a href="{{ route('home') }}" wire:navigate class="flex-shrink-0">
                <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center">
                    <span class="text-white font-bold text-lg">ص</span>
                </div>
            </a>

            <!-- Search -->
            <div class="flex-1 max-w-xl">
                <livewire:product-search />
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2">
                @auth
                <a href="{{ route('orders.index') }}" wire:navigate 
                   class="hidden sm:flex p-2.5 hover:bg-warm-100 rounded-xl transition-colors relative">
                    <svg class="w-6 h-6 text-warm-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </a>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 p-2 hover:bg-warm-100 rounded-xl transition-colors">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-primary-700 font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <span class="hidden md:block text-sm font-medium text-warm-700">{{ auth()->user()->name }}</span>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         class="absolute left-0 top-full mt-2 w-48 bg-white rounded-xl shadow-strong border border-warm-100 overflow-hidden z-50"
                         style="display: none;">
                        <a href="{{ route('orders.index') }}" wire:navigate class="block px-4 py-3 hover:bg-warm-50 text-warm-700">طلباتي</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-right px-4 py-3 hover:bg-warm-50 text-warm-700">تسجيل الخروج</button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" wire:navigate 
                   class="hidden sm:flex items-center gap-2 px-4 py-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    تسجيل الدخول
                </a>
                @endauth
            </div>
        </div>

        <!-- Categories Nav -->
        <nav class="hidden md:flex items-center gap-1 pb-2 overflow-x-auto no-scrollbar">
            @php
            $navCategories = \App\Models\Category::active()->root()->with('children')->limit(8)->get();
            @endphp
            @foreach($navCategories as $cat)
            <a href="{{ route('products.category', $cat->slug) }}" wire:navigate
               class="px-3 py-1.5 text-sm text-warm-600 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-colors whitespace-nowrap">
                {{ $cat->name }}
            </a>
            @endforeach
        </nav>
    </div>
</header>
