<div class="flex items-center gap-2" x-data="{ qty: @entangle('quantity') }">
    <div class="flex items-center bg-warm-100 rounded-xl overflow-hidden">
        <button wire:click="decrement" 
                class="w-10 h-10 flex items-center justify-center hover:bg-warm-200 transition-colors text-warm-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
            </svg>
        </button>
        <span class="w-10 text-center font-semibold text-warm-900" x-text="qty"></span>
        <button wire:click="increment" 
                class="w-10 h-10 flex items-center justify-center hover:bg-warm-200 transition-colors text-warm-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </button>
    </div>

    <button wire:click="addToCart" 
            wire:loading.attr="disabled"
            class="flex-1 btn-primary py-3 gap-2 relative overflow-hidden"
            :class="{ 'bg-green-600': showSuccess }">
        <span wire:loading.remove wire:target="addToCart">
            <span x-show="!showSuccess" class="flex items-center gap-2 justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                أضف إلى السلة
            </span>
            <span x-show="showSuccess" x-cloak class="flex items-center gap-2 justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                تمت الإضافة!
            </span>
        </span>
        <span wire:loading wire:target="addToCart" class="flex items-center gap-2 justify-center">
            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            جاري الإضافة...
        </span>
    </button>
</div>
