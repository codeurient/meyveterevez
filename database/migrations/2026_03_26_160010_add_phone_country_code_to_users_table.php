<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_country_code', 10)
                ->nullable()
                ->after('phone')
                ->comment('FK to phone_country_codes.code — e.g. AZ');

            $table->foreign('phone_country_code')
                ->references('code')
                ->on('phone_country_codes')
                ->nullOnDelete();

            $table->index('phone_country_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['phone_country_code']);
            $table->dropIndex(['phone_country_code']);
            $table->dropColumn('phone_country_code');
        });
    }
};
