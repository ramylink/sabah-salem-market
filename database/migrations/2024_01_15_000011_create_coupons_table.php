<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed', 'free_shipping']);
            $table->decimal('value', 10, 3)->default(0);
            $table->decimal('min_order_amount', 10, 3)->nullable();
            $table->decimal('max_discount_amount', 10, 3)->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_limit_per_user')->nullable();
            $table->integer('used_count')->default(0);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('applies_to', ['all', 'categories', 'products'])->default('all');
            $table->json('category_ids')->nullable();
            $table->json('product_ids')->nullable();
            $table->json('exclude_product_ids')->nullable();
            $table->timestamps();

            $table->index('code');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
