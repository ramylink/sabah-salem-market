<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'category', 'brand', 'min_price', 'max_price', 
            'sort', 'in_stock', 'on_sale'
        ]);

        $products = $this->productRepository->getAll($filters, 24);

        $categories = Category::active()
            ->root()
            ->with(['children'])
            ->get();

        return view('pages.products.index', compact('products', 'categories', 'filters'));
    }

    public function show(string $slug)
    {
        $product = $this->productRepository->findBySlug($slug);

        if (!$product) {
            abort(404);
        }

        $relatedProducts = $this->productRepository->getRelatedProducts($product, 6);

        $recommendations = auth()->check() 
            ? $this->productRepository->getRecommendations(auth()->id(), 8)
            : $this->productRepository->getPopular(8);

        return view('pages.products.show', compact(
            'product', 
            'relatedProducts', 
            'recommendations'
        ));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (empty($query)) {
            return redirect()->route('products.index');
        }

        $products = $this->productRepository->search($query, [], 24);

        return view('pages.products.search', compact('products', 'query'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->active()->firstOrFail();

        $products = $this->productRepository->getByCategory(
            $category->id, 
            request()->only(['sort', 'min_price', 'max_price']), 
            24
        );

        return view('pages.products.category', compact('category', 'products'));
    }
}
