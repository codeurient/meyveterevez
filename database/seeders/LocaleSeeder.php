<?php

namespace Database\Seeders;

use App\Models\Locale;
use Illuminate\Database\Seeder;

class LocaleSeeder extends Seeder
{
    public function run(): void
    {
        $locales = [
            [
                'code' => 'az',
                'name' => 'Azərbaycan',
                'flag' => '🇦🇿',
                'is_active' => true,
                'is_default' => true,
                'sort_order' => 1,
            ],
            [
                'code' => 'en',
                'name' => 'English',
                'flag' => '🇬🇧',
                'is_active' => true,
                'is_default' => false,
                'sort_order' => 2,
            ],
        ];

        foreach ($locales as $locale) {
            Locale::updateOrCreate(['code' => $locale['code']], $locale);
        }
    }
}
