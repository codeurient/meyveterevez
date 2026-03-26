<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);  // snapshot of price at add time
            $table->timestamps();

            $table->unique(['user_id', 'product_id'], 'uq_cart_user_product');
            $table->index('user_id', 'idx_cart_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
