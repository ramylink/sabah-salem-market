<div>
    <!-- Overlay -->
    <div x-show="$wire.isOpen" 
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-50"
         x-on:click="$wire.close()"
         style="display: none;"></div>

    <!-- Drawer -->
    <div x-show="$wire.isOpen"
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed top-0 right-0 h-full w-full sm:w-[420px] bg-white z-50 shadow-2xl flex flex-col"
         style="display: none;">

        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-warm-100">
            <h2 class="text-xl font-bold text-warm-900">سلة التسوق</h2>
            <button wire:click="close" class="p-2 hover:bg-warm-100 rounded-xl transition-colors">
                <svg class="w-6 h-6 text-warm-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Items -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4">
            @if(count($cartItems) === 0)
            <div class="text-center py-12">
                <svg class="w-20 h-20 text-warm-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-warm-500 text-lg mb-2">السلة فارغة</p>
                <a href="{{ route('products.index') }}" wire:navigate
                   class="btn-primary text-sm">تصفح المنتجات</a>
            </div>
            @else
            @foreach($cartItems as $item)
            <div class="flex gap-3 p-3 bg-warm-50 rounded-xl" wire:key="cart-item-{{ $item['id'] }}">
                <img src="{{ $item['product_image'] }}" alt="{{ $item['product_name'] }}" 
                     class="w-20 h-20 object-cover rounded-lg flex-shrink-0" loading="lazy"/>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-warm-900 text-sm truncate">{{ $item['product_name'] }}</h3>
                    <p class="text-primary-700 font-bold text-sm mt-1">{{ $item['formatted_total'] }}</p>

                    <div class="flex items-center gap-2 mt-2">
                        <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})"
                                class="w-8 h-8 flex items-center justify-center bg-white rounded-lg border border-warm-200 hover:border-primary-400 transition-colors text-warm-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <span class="w-8 text-center font-semibold text-warm-900">{{ $item['quantity'] }}</span>
                        <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})"
                                class="w-8 h-8 flex items-center justify-center bg-white rounded-lg border border-warm-200 hover:border-primary-400 transition-colors text-warm-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        <button wire:click="removeItem({{ $item['id'] }})"
                                class="mr-auto text-warm-400 hover:text-danger-600 transition-colors p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>

        <!-- Footer -->
        @if(count($cartItems) > 0)
        <div class="border-t border-warm-100 p-4 space-y-3 bg-white">
            <div class="flex justify-between items-center">
                <span class="text-warm-600">المجموع</span>
                <span class="text-xl font-bold text-warm-900">{{ number_format($cartTotal, 3) }} د.ك</span>
            </div>
            <button wire:click="goToCheckout" 
                    class="btn-primary w-full py-4 text-lg">
                إتمام الطلب
            </button>
            <button wire:click="clearCart" 
                    class="btn-ghost w-full text-danger-600 hover:text-danger-700">
                إفراغ السلة
            </button>
        </div>
        @endif
    </div>

    <!-- Cart Button (Fixed) -->
    <button wire:click="open"
            class="fixed bottom-6 left-6 z-40 w-14 h-14 bg-primary-600 text-white rounded-full shadow-strong hover:bg-primary-700 transition-all hover:scale-110 flex items-center justify-center"
            x-data="{ count: {{ $cartCount }} }"
            x-on:cart-updated.window="count = $event.detail.count ?? {{ $cartCount }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        @if($cartCount > 0)
        <span class="absolute -top-1 -right-1 w-6 h-6 bg-accent-500 text-warm-900 text-xs font-bold rounded-full flex items-center justify-center">
            {{ $cartCount }}
        </span>
        @endif
    </button>
</div>
