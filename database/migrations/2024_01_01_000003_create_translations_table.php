<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale_code', 10);
            $table->string('group', 60);
            $table->string('key', 200);
            $table->text('value');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('locale_code')
                ->references('code')
                ->on('locales')
                ->onDelete('cascade');

            $table->unique(['locale_code', 'group', 'key']);
            $table->index(['locale_code', 'group']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
