<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->foreignId('store_profile_id')->nullable()->constrained('store_profiles')->nullOnDelete();
            $table->string('product_name', 255);   // snapshot at order time
            $table->string('product_image', 500)->nullable();
            $table->string('unit', 20)->default('kg');
            $table->decimal('unit_price', 10, 2);
            $table->unsignedInteger('quantity');
            $table->decimal('total', 10, 2);
            $table->timestamps();

            $table->index('order_id', 'idx_oitem_order');
            $table->index('product_id', 'idx_oitem_product');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
