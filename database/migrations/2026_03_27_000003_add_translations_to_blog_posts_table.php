<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->json('title_translations')->nullable()->after('title');
            $table->json('excerpt_translations')->nullable()->after('excerpt');
            $table->json('content_translations')->nullable()->after('content');
            $table->unsignedInteger('read_time')->default(1)->after('content_translations');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn(['title_translations', 'excerpt_translations', 'content_translations', 'read_time']);
        });
    }
};
