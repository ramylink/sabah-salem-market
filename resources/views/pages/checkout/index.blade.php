@extends('layouts.app')

@section('title', 'إتمام الطلب')

@section('content')
<div class="page-container py-8">
    <h1 class="text-2xl font-bold text-warm-900 mb-8">إتمام الطلب</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf

                <div class="bg-white rounded-2xl shadow-soft p-6">
                    <h2 class="text-lg font-bold text-warm-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        عنوان التوصيل
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-warm-700 mb-1">المنطقة *</label>
                            <input type="text" name="delivery_area" required 
                                   value="{{ old('delivery_area', $defaultAddress?->area ?? $user?->area) }}"
                                   class="input-field" placeholder="مثال: صباح السالم">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-warm-700 mb-1">القطعة</label>
                            <input type="text" name="delivery_block" 
                                   value="{{ old('delivery_block', $defaultAddress?->block ?? $user?->block) }}"
                                   class="input-field" placeholder="مثال: 1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-warm-700 mb-1">الشارع</label>
                            <input type="text" name="delivery_street" 
                                   value="{{ old('delivery_street', $defaultAddress?->street ?? $user?->street) }}"
                                   class="input-field" placeholder="مثال: الرئيسي">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-warm-700 mb-1">المبنى</label>
                            <input type="text" name="delivery_building" 
                                   value="{{ old('delivery_building', $defaultAddress?->building ?? $user?->building) }}"
                                   class="input-field" placeholder="مثال: 10">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-warm-700 mb-1">الدور</label>
                            <input type="text" name="delivery_floor" 
                                   value="{{ old('delivery_floor', $defaultAddress?->floor ?? $user?->floor) }}"
                                   class="input-field" placeholder="مثال: 2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-warm-700 mb-1">الشقة</label>
                            <input type="text" name="delivery_apartment" 
                                   value="{{ old('delivery_apartment', $defaultAddress?->apartment ?? $user?->apartment) }}"
                                   class="input-field" placeholder="مثال: 5">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-warm-700 mb-1">رقم الهاتف *</label>
                            <input type="tel" name="delivery_phone" required 
                                   value="{{ old('delivery_phone', $user?->phone) }}"
                                   class="input-field" placeholder="965XXXXXXXX">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-warm-700 mb-1">تعليمات التوصيل</label>
                        <textarea name="delivery_instructions" rows="2" class="input-field" 
                                  placeholder="أي تعليمات خاصة للتوصيل...">{{ old('delivery_instructions') }}</textarea>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-soft p-6 mt-6">
                    <h2 class="text-lg font-bold text-warm-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        طريقة الدفع
                    </h2>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-4 border-2 border-primary-500 bg-primary-50 rounded-xl cursor-pointer">
                            <input type="radio" name="payment_method" value="cash_on_delivery" checked class="w-5 h-5 text-primary-600">
                            <div class="flex-1">
                                <p class="font-semibold text-warm-900">الدفع عند الاستلام</p>
                                <p class="text-sm text-warm-500">ادفع نقداً عند استلام طلبك</p>
                            </div>
                            <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </label>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-soft p-6 mt-6">
                    <h2 class="text-lg font-bold text-warm-900 mb-4">ملاحظات إضافية</h2>
                    <textarea name="notes" rows="3" class="input-field" 
                              placeholder="أي ملاحظات خاصة بالطلب...">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="btn-primary w-full py-4 text-lg mt-6">
                    تأكيد الطلب
                </button>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-soft p-6 sticky top-24">
                <h2 class="text-lg font-bold text-warm-900 mb-4">ملخص الطلب</h2>

                <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                    @foreach($cartSummary['items'] as $item)
                    <div class="flex items-center gap-3">
                        <img src="{{ $item['product_image'] }}" alt="" class="w-12 h-12 object-cover rounded-lg">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-warm-900 truncate">{{ $item['product_name'] }}</p>
                            <p class="text-xs text-warm-500">{{ $item['quantity'] }} × {{ number_format($item['unit_price'], 3) }} د.ك</p>
                        </div>
                        <span class="text-sm font-bold">{{ $item['formatted_total'] }}</span>
                    </div>
                    @endforeach
                </div>

                <!-- Coupon -->
                <div class="border-t border-warm-200 pt-4 mb-4">
                    <div class="flex gap-2">
                        <input type="text" id="coupon-code" placeholder="كود الخصم" class="input-field py-2 text-sm flex-1">
                        <button onclick="applyCoupon()" class="btn-secondary py-2 px-4 text-sm">تطبيق</button>
                    </div>
                    <p id="coupon-message" class="text-sm mt-2 hidden"></p>
                </div>

                <div class="border-t border-warm-200 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-warm-500">المجموع الفرعي</span>
                        <span>{{ $cartSummary['formatted_subtotal'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-warm-500">رسوم التوصيل</span>
                        <span>{{ $cartSummary['subtotal'] >= 15 ? 'مجاني' : '1.500 د.ك' }}</span>
                    </div>
                    <div id="discount-row" class="flex justify-between hidden">
                        <span class="text-warm-500">الخصم</span>
                        <span class="text-danger-600" id="discount-amount">-0.000 د.ك</span>
                    </div>
                </div>

                <div class="border-t border-warm-200 mt-4 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-warm-900">الإجمالي</span>
                        <span class="text-2xl font-bold text-primary-700" id="total-amount">{{ number_format($cartSummary['total'], 3) }} د.ك</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function applyCoupon() {
    const code = document.getElementById('coupon-code').value;
    const messageEl = document.getElementById('coupon-message');

    fetch('{{ route("checkout.coupon") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ coupon_code: code })
    })
    .then(r => r.json())
    .then(data => {
        messageEl.classList.remove('hidden', 'text-green-600', 'text-red-600');
        messageEl.classList.add(data.success ? 'text-green-600' : 'text-red-600');
        messageEl.textContent = data.message;

        if (data.success) {
            document.getElementById('discount-row').classList.remove('hidden');
            document.getElementById('discount-amount').textContent = '-' + data.formatted_discount;
        }
    });
}
</script>
@endsection
