<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('set null');
            $table->string('product_name');
            $table->string('product_sku');
            $table->string('product_image')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 3);
            $table->decimal('total_price', 12, 3);
            $table->decimal('tax_amount', 10, 3)->default(0);
            $table->decimal('discount_amount', 10, 3)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
