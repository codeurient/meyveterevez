<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phone_country_codes', function (Blueprint $table) {
            $table->string('code', 10)->primary();   // ISO 3166-1 alpha-2, e.g. "AZ"
            $table->string('name', 100);             // English name
            $table->string('native_name', 100);      // Name in native language
            $table->string('phone_code', 10);        // e.g. "+994"
            $table->string('trunk_prefix', 5)->nullable();  // e.g. "0"
            $table->string('idd_prefix', 10)->nullable();   // e.g. "00"
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index('phone_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phone_country_codes');
    }
};
