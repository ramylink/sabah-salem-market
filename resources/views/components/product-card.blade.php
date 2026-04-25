<div class="card-product group" data-animate>
    <a href="{{ route('products.show', $product->slug) }}" wire:navigate class="block">
        <div class="relative aspect-square overflow-hidden bg-warm-100">
            <img src="{{ $product->featured_image_url }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                 loading="lazy"/>

            @if($product->discount_percentage)
            <div class="absolute top-3 left-3 bg-danger-500 text-white text-xs font-bold px-2.5 py-1 rounded-lg">
                -{{ $product->discount_percentage }}%
            </div>
            @endif

            @if($product->is_new)
            <div class="absolute top-3 {{ $product->discount_percentage ? 'left-16' : 'left-3' }} bg-accent-500 text-warm-900 text-xs font-bold px-2.5 py-1 rounded-lg">
                جديد
            </div>
            @endif

            @if(!$product->is_in_stock)
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                <span class="bg-warm-900 text-white px-4 py-2 rounded-xl font-bold text-sm">نفذت الكمية</span>
            </div>
            @endif
        </div>

        <div class="p-4">
            <p class="text-xs text-warm-500 mb-1">{{ $product->category?->name }}</p>
            <h3 class="font-semibold text-warm-900 text-sm mb-2 line-clamp-2 group-hover:text-primary-700 transition-colors">
                {{ $product->name }}
            </h3>

            <div class="flex items-center gap-2">
                <span class="font-bold text-primary-700">{{ $product->formatted_price }}</span>
                @if($product->compare_price)
                <span class="text-sm text-warm-400 line-through">{{ $product->formatted_compare_price }}</span>
                @endif
            </div>

            <p class="text-xs text-warm-400 mt-1">{{ $product->weight }} {{ $product->unit }}</p>
        </div>
    </a>

    @if($product->is_in_stock)
    <div class="px-4 pb-4">
        <livewire:add-to-cart-button :product-id="$product->id" />
    </div>
    @endif
</div>
