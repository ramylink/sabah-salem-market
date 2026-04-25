<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartSummary = $this->cartService->getCartSummary();
        return view('pages.cart.index', compact('cartSummary'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|integer|exists:product_variants,id',
        ]);

        try {
            $item = $this->cartService->addItem(
                $request->product_id,
                $request->quantity,
                $request->variant_id,
                $request->notes
            );

            return response()->json([
                'success' => true,
                'message' => 'تمت الإضافة إلى السلة',
                'cart_count' => $this->cartService->getCartCount(),
                'item' => $item,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function update(Request $request, int $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $item = $this->cartService->updateQuantity($itemId, $request->quantity);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الكمية',
                'cart_total' => $this->cartService->getCartTotal(),
                'item' => $item,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function remove(int $itemId)
    {
        try {
            $this->cartService->removeItem($itemId);

            return response()->json([
                'success' => true,
                'message' => 'تم حذف المنتج',
                'cart_count' => $this->cartService->getCartCount(),
                'cart_total' => $this->cartService->getCartTotal(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function clear()
    {
        $this->cartService->clearCart();

        return response()->json([
            'success' => true,
            'message' => 'تم إفراغ السلة',
        ]);
    }
}
