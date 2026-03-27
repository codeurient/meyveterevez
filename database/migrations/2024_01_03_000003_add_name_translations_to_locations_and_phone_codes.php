<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            // JSON: {"az": "Azərbaycan", "en": "Azerbaijan"}
            // Existing `name` column kept as fallback / legacy
            $table->json('name_translations')->nullable()->after('name');
        });

        Schema::table('phone_country_codes', function (Blueprint $table) {
            // JSON: {"az": "Azərbaycan", "en": "Azerbaijan"}
            $table->json('name_translations')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('name_translations');
        });

        Schema::table('phone_country_codes', function (Blueprint $table) {
            $table->dropColumn('name_translations');
        });
    }
};
