<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['new', 'confirmed', 'processing', 'packing', 'shipped', 'delivered', 'cancelled', 'refunded'])->default('new');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->default('cash_on_delivery');
            $table->string('payment_reference')->nullable();
            $table->decimal('subtotal', 12, 3);
            $table->decimal('discount_amount', 12, 3)->default(0);
            $table->decimal('tax_amount', 12, 3)->default(0);
            $table->decimal('delivery_fee', 10, 3)->default(0);
            $table->decimal('total', 12, 3);
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');
            $table->string('coupon_code')->nullable();
            $table->text('notes')->nullable();
            $table->string('delivery_address');
            $table->string('delivery_area');
            $table->string('delivery_block')->nullable();
            $table->string('delivery_street')->nullable();
            $table->string('delivery_building')->nullable();
            $table->string('delivery_floor')->nullable();
            $table->string('delivery_apartment')->nullable();
            $table->string('delivery_phone');
            $table->text('delivery_instructions')->nullable();
            $table->date('scheduled_delivery_date')->nullable();
            $table->time('scheduled_delivery_time')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('payment_status');
            $table->index('user_id');
            $table->index('created_at');
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
