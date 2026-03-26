<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('store_profile_id')->nullable()->constrained('store_profiles')->nullOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();

            $table->string('name', 255);
            $table->string('slug', 500)->unique();
            $table->text('description')->nullable();

            // Pricing
            $table->decimal('price', 10, 2);                         // current price (₼)
            $table->decimal('original_price', 10, 2)->nullable();    // before discount
            $table->unsignedTinyInteger('discount_percent')->default(0);

            // Unit/Weight
            $table->string('unit', 20)->default('kg');               // kg, g, piece, bunch, box
            $table->decimal('weight_per_unit', 8, 3)->nullable();    // e.g. 1.000 kg

            // Stock
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->boolean('in_stock')->default(true);
            $table->unsignedInteger('min_order_qty')->default(1);
            $table->unsignedInteger('max_order_qty')->nullable();

            // Attributes
            $table->boolean('is_organic')->default(false);
            $table->boolean('is_fresh_today')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_top_seller')->default(false);

            // Ratings (denormalized)
            $table->decimal('rating_avg', 3, 2)->default(0.00);
            $table->unsignedInteger('rating_count')->default(0);
            $table->unsignedInteger('sale_count')->default(0);
            $table->unsignedInteger('views_count')->default(0);

            // Status
            $table->enum('status', ['draft', 'pending', 'active', 'inactive'])->default('draft');

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('user_id', 'idx_prod_user');
            $table->index('store_profile_id', 'idx_prod_store');
            $table->index('category_id', 'idx_prod_category');
            $table->index('status', 'idx_prod_status');
            $table->index(['status', 'in_stock'], 'idx_prod_public');
            $table->index(['is_featured', 'status'], 'idx_prod_featured');
            $table->index(['rating_avg', 'status'], 'idx_prod_rating');
            $table->index(['discount_percent', 'status'], 'idx_prod_discount');
            $table->index('created_at', 'idx_prod_created');
            $table->fullText(['name', 'description'], 'fulltext_product_search');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
