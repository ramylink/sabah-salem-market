<?php

namespace App\Providers;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\CartService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->singleton(CartService::class);
    }

    public function boot(): void
    {
        // Share cart count with all views
        View::composer('*', function ($view) {
            try {
                $cartService = app(CartService::class);
                $view->with('cartCount', $cartService->getCartCount());
            } catch (\Exception $e) {
                $view->with('cartCount', 0);
            }
        });
    }
}
