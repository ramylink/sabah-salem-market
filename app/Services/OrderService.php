<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    private CartService $cartService;
    private ProductRepository $productRepository;

    public function __construct(CartService $cartService, ProductRepository $productRepository)
    {
        $this->cartService = $cartService;
        $this->productRepository = $productRepository;
    }

    public function createOrder(array $data): Order
    {
        $cartSummary = $this->cartService->getCartSummary();

        if ($cartSummary['item_count'] === 0) {
            throw new \Exception('السلة فارغة');
        }

        return DB::transaction(function () use ($data, $cartSummary) {
            // Validate stock
            foreach ($cartSummary['items'] as $item) {
                $product = $item->product;
                if ($product->stock_quantity < $item->quantity) {
                    throw new \Exception("المنتج {$product->name} غير متوفر بالكمية المطلوبة");
                }
            }

            // Calculate totals
            $subtotal = $cartSummary['subtotal'];
            $discountAmount = 0;
            $coupon = null;

            if (!empty($data['coupon_code'])) {
                $coupon = Coupon::where('code', $data['coupon_code'])->valid()->first();
                if ($coupon && $coupon->canBeUsedBy(Auth::user())) {
                    $discountAmount = $coupon->calculateDiscount($subtotal);
                }
            }

            $deliveryFee = $subtotal >= 15 ? 0 : 1.500;
            $taxAmount = round(($subtotal - $discountAmount) * 0, 3); // No tax for now
            $total = $subtotal - $discountAmount + $deliveryFee + $taxAmount;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => Order::STATUS_NEW,
                'payment_status' => Order::PAYMENT_PENDING,
                'payment_method' => $data['payment_method'] ?? 'cash_on_delivery',
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'coupon_id' => $coupon?->id,
                'coupon_code' => $coupon?->code,
                'notes' => $data['notes'] ?? null,
                'delivery_address' => $data['delivery_address'],
                'delivery_area' => $data['delivery_area'],
                'delivery_block' => $data['delivery_block'] ?? null,
                'delivery_street' => $data['delivery_street'] ?? null,
                'delivery_building' => $data['delivery_building'] ?? null,
                'delivery_floor' => $data['delivery_floor'] ?? null,
                'delivery_apartment' => $data['delivery_apartment'] ?? null,
                'delivery_phone' => $data['delivery_phone'],
                'delivery_instructions' => $data['delivery_instructions'] ?? null,
                'scheduled_delivery_date' => $data['scheduled_delivery_date'] ?? null,
                'scheduled_delivery_time' => $data['scheduled_delivery_time'] ?? null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Create order items
            foreach ($cartSummary['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'product_name' => $item->product->name,
                    'product_sku' => $item->product->sku,
                    'product_image' => $item->product->featured_image,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                    'notes' => $item->notes,
                ]);

                // Decrement stock
                $this->productRepository->decrementStock($item->product_id, $item->quantity);
            }

            // Update coupon usage
            if ($coupon) {
                $coupon->increment('used_count');
            }

            // Clear cart
            $this->cartService->clearCart();

            // Log order creation
            Log::info('Order created', ['order_id' => $order->id, 'total' => $total]);

            return $order->fresh(['items']);
        });
    }

    public function reorder(int $orderId): Order
    {
        $originalOrder = Order::with('items')->findOrFail($orderId);

        if (!$originalOrder->canReorder()) {
            throw new \Exception('لا يمكن إعادة طلب هذا الطلب');
        }

        // Add items to cart
        foreach ($originalOrder->items as $item) {
            try {
                $this->cartService->addItem(
                    $item->product_id,
                    $item->quantity,
                    $item->variant_id,
                    $item->notes
                );
            } catch (\Exception $e) {
                Log::warning('Failed to add item to cart during reorder', [
                    'product_id' => $item->product_id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $originalOrder;
    }

    public function cancelOrder(int $orderId, string $reason = ''): Order
    {
        $order = Order::findOrFail($orderId);

        if (!$order->canCancel()) {
            throw new \Exception('لا يمكن إلغاء هذا الطلب');
        }

        return DB::transaction(function () use ($order, $reason) {
            // Restore stock
            foreach ($order->items as $item) {
                $this->productRepository->incrementStock($item->product_id, $item->quantity);
            }

            $order->updateStatus(Order::STATUS_CANCELLED, $reason);
            $order->update([
                'cancelled_at' => now(),
                'cancellation_reason' => $reason,
            ]);

            return $order->fresh();
        });
    }

    public function getOrderStats(?int $userId = null): array
    {
        $query = Order::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return [
            'total_orders' => $query->count(),
            'total_revenue' => $query->sum('total'),
            'pending_orders' => (clone $query)->pending()->count(),
            'delivered_orders' => (clone $query)->delivered()->count(),
            'today_orders' => (clone $query)->today()->count(),
            'today_revenue' => (clone $query)->today()->sum('total'),
        ];
    }
}
