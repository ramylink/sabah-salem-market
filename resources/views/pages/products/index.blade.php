@extends('layouts.app')

@section('title', 'جميع المنتجات')

@section('content')
<div class="page-container py-8">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar Filters -->
        <aside class="lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-soft p-5 sticky top-24">
                <h3 class="font-bold text-warm-900 mb-4">تصفية النتائج</h3>

                <div class="mb-6">
                    <h4 class="font-semibold text-sm text-warm-700 mb-3">الفئات</h4>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        @foreach($categories as $cat)
                        <a href="{{ route('products.category', $cat->slug) }}" wire:navigate
                           class="flex items-center justify-between p-2 rounded-lg hover:bg-warm-50 transition-colors {{ request('category') == $cat->slug ? 'bg-primary-50 text-primary-700' : 'text-warm-600' }}">
                            <span class="text-sm">{{ $cat->name }}</span>
                            <span class="text-xs bg-warm-100 px-2 py-0.5 rounded-full">{{ $cat->products_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold text-sm text-warm-700 mb-3">نطاق السعر</h4>
                    <div class="flex items-center gap-2">
                        <input type="number" placeholder="من" class="input-field py-2 text-sm" value="{{ request('min_price') }}">
                        <span class="text-warm-400">-</span>
                        <input type="number" placeholder="إلى" class="input-field py-2 text-sm" value="{{ request('max_price') }}">
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-sm text-warm-700 mb-3">الترتيب</h4>
                    <select onchange="window.location.href = this.value" class="input-field py-2 text-sm">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>السعر: من الأقل</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>السعر: من الأعلى</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" {{ request('sort') == 'popular' ? 'selected' : '' }}>الأكثر مبيعاً</option>
                    </select>
                </div>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-warm-900">جميع المنتجات</h1>
                <span class="text-warm-500 text-sm">{{ $products->total() }} منتج</span>
            </div>

            @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($products as $product)
                @include('components.product-card', ['product' => $product])
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <svg class="w-20 h-20 text-warm-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-warm-500 text-lg">لا توجد منتجات</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
