@extends('layouts.app')

@section('title', 'تم تأكيد الطلب')

@section('content')
<div class="page-container py-16">
    <div class="max-w-lg mx-auto text-center">
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-warm-900 mb-4">تم تأكيد طلبك بنجاح!</h1>
        <p class="text-warm-500 mb-2">رقم الطلب: <span class="font-bold text-warm-900">{{ $order->order_number }}</span></p>
        <p class="text-warm-500 mb-8">سنقوم بالتواصل معك قريباً لتأكيد الطلب</p>

        <div class="bg-warm-50 rounded-2xl p-6 mb-8 text-right">
            <h3 class="font-bold text-warm-900 mb-4">تفاصيل الطلب</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-warm-500">الإجمالي</span>
                    <span class="font-bold">{{ $order->formatted_total }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-warm-500">طريقة الدفع</span>
                    <span>الدفع عند الاستلام</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-warm-500">الحالة</span>
                    <span class="badge badge-primary">{{ $order->status_label }}</span>
                </div>
            </div>
        </div>

        <div class="flex gap-3 justify-center">
            <a href="{{ route('orders.show', $order->order_number) }}" wire:navigate class="btn-primary">
                تتبع الطلب
            </a>
            <a href="{{ route('products.index') }}" wire:navigate class="btn-secondary">
                مواصلة التسوق
            </a>
        </div>
    </div>
</div>
@endsection
