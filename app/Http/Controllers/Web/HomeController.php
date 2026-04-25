<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $featuredCategories = Cache::remember('home:categories', 3600, function () {
            return Category::active()
                ->featured()
                ->withCount(['products' => function ($q) {
                    $q->active();
                }])
                ->limit(8)
                ->get();
        });

        $featuredProducts = $this->productRepository->getFeatured(8);
        $newArrivals = $this->productRepository->getNewArrivals(8);
        $onSale = $this->productRepository->getOnSale(8);
        $popularProducts = $this->productRepository->getPopular(8);

        return view('pages.home', compact(
            'featuredCategories',
            'featuredProducts',
            'newArrivals',
            'onSale',
            'popularProducts'
        ));
    }
}
