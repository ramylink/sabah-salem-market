<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('sku')->unique();
            $table->string('barcode')->unique()->nullable();
            $table->decimal('price', 10, 3);
            $table->decimal('compare_price', 10, 3)->nullable();
            $table->decimal('cost', 10, 3)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->enum('stock_status', ['in_stock', 'low_stock', 'out_of_stock'])->default('in_stock');
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('unit', 20)->default('piece');
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            $table->json('images')->nullable();
            $table->string('featured_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_on_sale')->default(false);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->integer('min_order_quantity')->default(1);
            $table->integer('max_order_quantity')->default(99);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('tags')->nullable();
            $table->json('nutritional_info')->nullable();
            $table->json('allergens')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'is_featured']);
            $table->index(['is_active', 'is_new']);
            $table->index(['is_active', 'is_on_sale']);
            $table->index(['category_id', 'is_active']);
            $table->index('stock_status');
            $table->index('price');
            $table->fullText(['name', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
