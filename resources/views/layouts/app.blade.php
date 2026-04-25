<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#1B5E20">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'جمعية صباح السالم التعاونية') | متجرك الإلكتروني المفضل</title>
    <meta name="description" content="@yield('meta_description', 'تسوق أونلاين من جمعية صباح السالم التعاونية - خضروات طازجة، لحوم، ألبان، ومستلزمات منزلية بأفضل الأسعار وتوصيل سريع')">

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icon-192x192.png">

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
        .page-loading { opacity: 0; transition: opacity 0.3s; }
        .page-loaded { opacity: 1; }
    </style>
</head>
<body class="page-loading" x-data="{ toast: null }" 
      x-on:toast.window="toast = $event.detail; setTimeout(() => toast = null, 3000)"
      x-init="$nextTick(() => document.body.classList.add('page-loaded'))">

    <!-- Toast Notifications -->
    <div class="fixed top-4 left-4 z-[100] space-y-2" x-cloak>
        <template x-if="toast">
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-10"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-10"
                 :class="{
                    'bg-green-500 text-white': toast.type === 'success',
                    'bg-red-500 text-white': toast.type === 'error',
                    'bg-yellow-500 text-white': toast.type === 'warning',
                    'bg-blue-500 text-white': toast.type === 'info'
                 }"
                 class="px-6 py-3 rounded-xl shadow-strong flex items-center gap-3 min-w-[300px]">
                <span x-text="toast.message"></span>
                <button @click="toast = null" class="mr-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </template>
    </div>

    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main class="min-h-screen pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Cart Drawer -->
    <livewire:cart-drawer />

    @livewireScripts
</body>
</html>
