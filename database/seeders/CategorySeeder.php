<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // ==================== ROOT CATEGORIES ====================
        $roots = [
            ['slug' => 'meyveler',        'name' => 'Meyvələr',          'icon' => '🍎', 'color' => '#EF4444', 'sort_order' => 1],
            ['slug' => 'terevezer',       'name' => 'Tərəvəzlər',        'icon' => '🥦', 'color' => '#22C55E', 'sort_order' => 2],
            ['slug' => 'goyertiler',      'name' => 'Göyərtilər',        'icon' => '🌿', 'color' => '#16A34A', 'sort_order' => 3],
            ['slug' => 'quru-meyveler',   'name' => 'Quru Meyvələr',     'icon' => '🥜', 'color' => '#D97706', 'sort_order' => 4],
            ['slug' => 'ferma-mehsullari','name' => 'Ferma Məhsulları',  'icon' => '🥚', 'color' => '#F59E0B', 'sort_order' => 5],
            ['slug' => 'organik',         'name' => 'Üzvi Məhsullar',    'icon' => '🌱', 'color' => '#10B981', 'sort_order' => 6],
        ];

        $rootIds = [];
        foreach ($roots as $cat) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $cat['slug']],
                array_merge($cat, [
                    'parent_id'   => null,
                    'level'       => 1,
                    'path'        => null,
                    'is_active'   => true,
                    'description' => null,
                    'image'       => null,
                    'meta_title'  => null,
                    'meta_description' => null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ])
            );
            $rootIds[$cat['slug']] = DB::table('categories')->where('slug', $cat['slug'])->value('id');
        }

        // ==================== SUB-CATEGORIES: MEYVƏLƏR ====================
        $fruitSubs = [
            ['slug' => 'alma-armud',   'name' => 'Alma & Armud',      'icon' => '🍏', 'sort_order' => 1],
            ['slug' => 'uzum',         'name' => 'Üzüm',              'icon' => '🍇', 'sort_order' => 2],
            ['slug' => 'narinci-limon','name' => 'Narınc & Limon',    'icon' => '🍋', 'sort_order' => 3],
            ['slug' => 'ciy-meyveler', 'name' => 'Çiy Meyvələr',     'icon' => '🍓', 'sort_order' => 4],
            ['slug' => 'tropik',       'name' => 'Tropik Meyvələr',   'icon' => '🍌', 'sort_order' => 5],
        ];
        $this->insertSubs($fruitSubs, $rootIds['meyveler'], 'meyveler');

        // ==================== SUB-CATEGORIES: TƏRƏVƏZLƏr ====================
        $vegSubs = [
            ['slug' => 'yarpaq-terevezer',  'name' => 'Yarpaq Tərəvəzlər', 'icon' => '🥬', 'sort_order' => 1],
            ['slug' => 'kok-terevezer',     'name' => 'Kök Tərəvəzlər',    'icon' => '🥕', 'sort_order' => 2],
            ['slug' => 'meyve-terevezer',   'name' => 'Meyvəli Tərəvəz',   'icon' => '🍅', 'sort_order' => 3],
            ['slug' => 'soganagillar',      'name' => 'Soğan & Sarımsaq',  'icon' => '🧄', 'sort_order' => 4],
            ['slug' => 'qusambaligi',       'name' => 'Qovun & Qarpız',    'icon' => '🍉', 'sort_order' => 5],
        ];
        $this->insertSubs($vegSubs, $rootIds['terevezer'], 'terevezer');
    }

    private function insertSubs(array $subs, int $parentId, string $parentSlug): void
    {
        foreach ($subs as $cat) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $cat['slug']],
                array_merge($cat, [
                    'parent_id'        => $parentId,
                    'level'            => 2,
                    'path'             => (string) $parentId,
                    'color'            => null,
                    'is_active'        => true,
                    'description'      => null,
                    'image'            => null,
                    'meta_title'       => null,
                    'meta_description' => null,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ])
            );
        }
    }
}
