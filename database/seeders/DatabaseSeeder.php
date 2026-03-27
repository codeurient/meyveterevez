<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Order matters: locales must exist before translations (FK constraint)
        $this->call([
            LocaleSeeder::class,
            LocationSeeder::class,
            PhoneCountryCodeSeeder::class,
            TranslationSeeder::class,
            SliderSeeder::class,
            CategorySeeder::class,
            CatalogSeeder::class,
        ]);
    }
}
