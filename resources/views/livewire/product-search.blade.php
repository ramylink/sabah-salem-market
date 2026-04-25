<div class="relative w-full" x-data="{ open: @entangle('showResults') }">
    <div class="relative">
        <input
            wire:model.live.debounce.300ms="query"
            type="text"
            placeholder="ابحث عن منتجات..."
            class="w-full pr-12 pl-4 py-3 bg-warm-50 border border-warm-200 rounded-2xl text-warm-900 
                   placeholder:text-warm-400 focus:outline-none focus:ring-2 focus:ring-primary-500 
                   focus:border-transparent transition-all duration-200 text-base"
            autocomplete="off"
            x-on:focus="if ($wire.query.length >= $wire.minChars) $wire.showResults = true"
            x-on:keydown.escape="$wire.clearSearch()"
        />
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-warm-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        @if($query)
        <button wire:click="clearSearch" class="absolute left-4 top-1/2 -translate-y-1/2 text-warm-400 hover:text-warm-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        @endif
    </div>

    @if($showResults && count($results) > 0)
    <div class="absolute z-50 w-full mt-2 bg-white rounded-2xl shadow-strong border border-warm-100 overflow-hidden"
         x-on:click.away="$wire.showResults = false">
        <div class="max-h-96 overflow-y-auto">
            @foreach($results as $result)
            <button wire:click="selectProduct({{ $result['id'] }})" 
                    class="w-full flex items-center gap-4 p-4 hover:bg-warm-50 transition-colors text-right">
                <img src="{{ $result['image'] }}" alt="{{ $result['name'] }}" 
                     class="w-16 h-16 object-cover rounded-xl flex-shrink-0" loading="lazy"/>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-warm-900 truncate">{{ $result['name'] }}</p>
                    <p class="text-sm text-warm-500">{{ $result['category'] }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="font-bold text-primary-700">{{ $result['price'] }}</span>
                        @if($result['discount'])
                        <span class="badge badge-danger text-xs">-{{ $result['discount'] }}%</span>
                        @endif
                    </div>
                </div>
                <svg class="w-5 h-5 text-warm-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            @endforeach
        </div>
        <div class="p-3 border-t border-warm-100 bg-warm-50">
            <a href="{{ route('products.search', ['q' => $query]) }}" 
               class="block text-center text-primary-600 font-medium hover:text-primary-700">
                عرض كل النتائج
            </a>
        </div>
    </div>
    @elseif($showResults && strlen($query) >= $minChars)
    <div class="absolute z-50 w-full mt-2 bg-white rounded-2xl shadow-strong border border-warm-100 p-6 text-center">
        <svg class="w-12 h-12 text-warm-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-warm-500">لا توجد نتائج لـ "{{ $query }}"</p>
    </div>
    @endif
</div>
