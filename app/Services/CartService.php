<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    private string $sessionId;

    public function __construct()
    {
        $this->sessionId = Session::getId();
    }

    public function getCartItems()
    {
        $query = CartItem::with(['product', 'variant']);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', $this->sessionId);
        }

        return $query->get();
    }

    public function getCartCount(): int
    {
        return $this->getCartItems()->sum('quantity');
    }

    public function getCartTotal(): float
    {
        return $this->getCartItems()->sum('total_price');
    }

    public function addItem(int $productId, int $quantity = 1, ?int $variantId = null, ?string $notes = null): CartItem
    {
        $product = Product::findOrFail($productId);

        if (!$product->is_in_stock) {
            throw new \Exception('المنتج غير متوفر حالياً');
        }

        if ($product->stock_quantity < $quantity) {
            throw new \Exception('الكمية المطلوبة غير متوفرة');
        }

        if ($quantity < $product->min_order_quantity) {
            throw new \Exception('الحد الأدنى للطلب هو ' . $product->min_order_quantity);
        }

        if ($quantity > $product->max_order_quantity) {
            throw new \Exception('الحد الأقصى للطلب هو ' . $product->max_order_quantity);
        }

        $unitPrice = $variantId 
            ? ProductVariant::findOrFail($variantId)->final_price 
            : $product->price;

        $query = CartItem::where('product_id', $productId)
            ->where('variant_id', $variantId);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', $this->sessionId);
        }

        $cartItem = $query->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;

            if ($newQuantity > $product->max_order_quantity) {
                throw new \Exception('الحد الأقصى للطلب هو ' . $product->max_order_quantity);
            }

            $cartItem->update([
                'quantity' => $newQuantity,
                'notes' => $notes ?? $cartItem->notes,
            ]);
        } else {
            $cartItem = CartItem::create([
                'user_id' => Auth::id(),
                'session_id' => Auth::check() ? null : $this->sessionId,
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $unitPrice * $quantity,
                'notes' => $notes,
            ]);
        }

        return $cartItem->fresh(['product', 'variant']);
    }

    public function updateQuantity(int $cartItemId, int $quantity): CartItem
    {
        $cartItem = $this->getCartItem($cartItemId);
        $product = $cartItem->product;

        if ($quantity < 1) {
            $this->removeItem($cartItemId);
            throw new \Exception('تم حذف المنتج من السلة');
        }

        if ($quantity > $product->max_order_quantity) {
            throw new \Exception('الحد الأقصى للطلب هو ' . $product->max_order_quantity);
        }

        if ($product->stock_quantity < $quantity) {
            throw new \Exception('الكمية المطلوبة غير متوفرة');
        }

        $cartItem->update(['quantity' => $quantity]);
        return $cartItem->fresh(['product', 'variant']);
    }

    public function removeItem(int $cartItemId): bool
    {
        $cartItem = $this->getCartItem($cartItemId);
        return $cartItem->delete();
    }

    public function clearCart(): bool
    {
        $query = CartItem::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', $this->sessionId);
        }

        return $query->delete();
    }

    public function mergeGuestCart(int $userId): void
    {
        $guestItems = CartItem::where('session_id', $this->sessionId)
            ->whereNull('user_id')
            ->get();

        foreach ($guestItems as $item) {
            $existing = CartItem::where('user_id', $userId)
                ->where('product_id', $item->product_id)
                ->where('variant_id', $item->variant_id)
                ->first();

            if ($existing) {
                $existing->update(['quantity' => $existing->quantity + $item->quantity]);
                $item->delete();
            } else {
                $item->update(['user_id' => $userId, 'session_id' => null]);
            }
        }
    }

    public function getCartSummary(): array
    {
        $items = $this->getCartItems();
        $subtotal = $items->sum('total_price');
        $itemCount = $items->sum('quantity');

        return [
            'items' => $items,
            'item_count' => $itemCount,
            'subtotal' => $subtotal,
            'formatted_subtotal' => number_format($subtotal, 3) . ' د.ك',
            'delivery_fee' => $subtotal >= 15 ? 0 : 1.500,
            'total' => $subtotal + ($subtotal >= 15 ? 0 : 1.500),
        ];
    }

    private function getCartItem(int $cartItemId): CartItem
    {
        $query = CartItem::where('id', $cartItemId);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', $this->sessionId);
        }

        return $query->firstOrFail();
    }
}
