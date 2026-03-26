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
            // Drop the generic 'name' column — replaced by first_name + last_name
            $table->dropColumn('name');

            // Profile fields (after email)
            $table->string('first_name', 80)->after('id');
            $table->string('last_name', 80)->after('first_name');
            $table->string('phone', 30)->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('phone');

            // Location: user's city (nullable until set in profile)
            $table->foreignId('location_id')
                ->nullable()
                ->after('date_of_birth')
                ->constrained('locations')
                ->nullOnDelete();

            // Profile avatar (WebP path)
            $table->string('avatar_path')->nullable()->after('location_id');

            // Preferred locale
            $table->string('locale_code', 10)->default('az')->after('avatar_path');

            $table->index('location_id');
            $table->index('locale_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropIndex(['location_id']);
            $table->dropIndex(['locale_code']);
            $table->dropColumn(['first_name', 'last_name', 'phone', 'date_of_birth', 'location_id', 'avatar_path', 'locale_code']);
            $table->string('name')->after('id');
        });
    }
};
