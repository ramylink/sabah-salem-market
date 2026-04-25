@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', $product->short_description)

@section('content')
<div class="page-container py-8">
    <nav class="flex items-center gap-2 text-sm text-warm-500 mb-6">
        <a href="{{ route('home') }}" wire:navigate class="hover:text-primary-600">الرئيسية</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        @if($product->category)
        <a href="{{ route('products.category', $product->category->slug) }}" wire:navigate class="hover:text-primary-600">{{ $product->category->name }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        @endif
        <span class="text-warm-900 font-medium">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-4">
            <div class="aspect-square bg-warm-100 rounded-2xl overflow-hidden">
                <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" 
                     class="w-full h-full object-cover" id="main-image"/>
            </div>
            @if(count($product->image_urls) > 1)
            <div class="flex gap-2 overflow-x-auto no-scrollbar">
                @foreach($product->image_urls as $img)
                <button onclick="document.getElementById('main-image').src='{{ $img }}'"
                        class="w-20 h-20 rounded-xl overflow-hidden border-2 border-transparent hover:border-primary-500 transition-colors flex-shrink-0">
                    <img src="{{ $img }}" alt="" class="w-full h-full object-cover"/>
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <div>
                @if($product->category)
                <p class="text-sm text-primary-600 font-medium mb-2">{{ $product->category->name }}</p>
                @endif
                <h1 class="text-2xl sm:text-3xl font-bold text-warm-900 mb-3">{{ $product->name }}</h1>

                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl font-bold text-primary-700">{{ $product->formatted_price }}</span>
                    @if($product->compare_price)
                    <span class="text-xl text-warm-400 line-through">{{ $product->formatted_compare_price }}</span>
                    <span class="badge badge-danger">وفر {{ $product->savings_amount }}</span>
                    @endif
                </div>

                <p class="text-warm-600 leading-relaxed">{{ $product->description }}</p>
            </div>

            <div class="flex items-center gap-4 text-sm">
                @if($product->is_in_stock)
                <span class="flex items-center gap-1 text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    متوفر
                </span>
                @else
                <span class="flex items-center gap-1 text-danger-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    غير متوفر
                </span>
                @endif
                <span class="text-warm-400">|</span>
                <span class="text-warm-500">SKU: {{ $product->sku }}</span>
            </div>

            @if($product->is_in_stock)
            <div class="p-6 bg-warm-50 rounded-2xl">
                <livewire:add-to-cart-button :product-id="$product->id" />
            </div>
            @endif

            <div class="border-t border-warm-200 pt-6">
                <h3 class="font-bold text-warm-900 mb-3">تفاصيل المنتج</h3>
                <dl class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <dt class="text-warm-500">الوزن</dt>
                        <dd class="font-medium text-warm-900">{{ $product->weight }} {{ $product->unit }}</dd>
                    </div>
                    @if($product->brand)
                    <div>
                        <dt class="text-warm-500">العلامة التجارية</dt>
                        <dd class="font-medium text-warm-900">{{ $product->brand->name }}</dd>
                    </div>
                    @endif
                    @if($product->expiry_date)
                    <div>
                        <dt class="text-warm-500">تاريخ الانتهاء</dt>
                        <dd class="font-medium text-warm-900">{{ $product->expiry_date->format('Y/m/d') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <section class="mt-16">
        <h2 class="text-2xl font-bold text-warm-900 mb-6">منتجات ذات صلة</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($relatedProducts as $product)
            @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    @endif

    @if($recommendations->count() > 0)
    <section class="mt-16">
        <h2 class="text-2xl font-bold text-warm-900 mb-6">قد يعجبك أيضاً</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($recommendations as $product)
            @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
