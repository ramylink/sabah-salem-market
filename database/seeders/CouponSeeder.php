<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME20',
                'name' => 'خصم الترحيب',
                'description' => 'خصم 20% على أول طلب لك',
                'type' => 'percentage',
                'value' => 20,
                'min_order_amount' => 5.000,
                'max_discount_amount' => 5.000,
                'usage_limit' => 1000,
                'usage_limit_per_user' => 1,
                'is_active' => true,
            ],
            [
                'code' => 'SAVE5',
                'name' => 'خصم 5 دينار',
                'description' => 'خصم 5 دينار على الطلبات فوق 20 دينار',
                'type' => 'fixed',
                'value' => 5.000,
                'min_order_amount' => 20.000,
                'usage_limit' => 500,
                'usage_limit_per_user' => 3,
                'is_active' => true,
            ],
            [
                'code' => 'FREESHIP',
                'name' => 'توصيل مجاني',
                'description' => 'توصيل مجاني على الطلبات فوق 15 دينار',
                'type' => 'free_shipping',
                'value' => 0,
                'min_order_amount' => 15.000,
                'usage_limit' => null,
                'usage_limit_per_user' => null,
                'is_active' => true,
            ],
            [
                'code' => 'WEEKEND15',
                'name' => 'خصم نهاية الأسبوع',
                'description' => 'خصم 15% نهاية كل أسبوع',
                'type' => 'percentage',
                'value' => 15,
                'min_order_amount' => 10.000,
                'max_discount_amount' => 10.000,
                'usage_limit' => 200,
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
