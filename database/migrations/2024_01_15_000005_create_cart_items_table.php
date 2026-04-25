<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable()->index();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('set null');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 3);
            $table->decimal('total_price', 10, 3);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'product_id']);
            $table->index(['session_id', 'product_id']);
            $table->unique(['user_id', 'product_id', 'variant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
