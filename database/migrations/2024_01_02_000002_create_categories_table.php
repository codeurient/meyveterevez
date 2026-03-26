<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();     // emoji or icon class
            $table->string('image')->nullable();    // WebP path
            $table->string('color', 20)->nullable(); // hex color for UI
            $table->integer('level')->default(1);   // 1=root, 2=sub, 3=sub-sub
            $table->string('path', 500)->nullable(); // ancestor IDs: 1/5/12
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->index('parent_id', 'idx_cat_parent');
            $table->index('slug', 'idx_cat_slug');
            $table->index(['is_active', 'sort_order'], 'idx_cat_active_order');
            $table->index('level', 'idx_cat_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
