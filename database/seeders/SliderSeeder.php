<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'title'       => 'Təzə Meyvə & Tərəvəz',
                'subtitle'    => 'Birbaşa fermerlərdən — hər gün təzə çatdırılır',
                'image'       => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=1920&q=75',
                'button_text' => 'İndi Alış-veriş Et',
                'link'        => '/products',
                'type'        => 'main_slider',
                'sort_order'  => 1,
                'is_active'   => true,
            ],
            [
                'title'       => 'Üzvi Məhsullar',
                'subtitle'    => 'Sertifikatlı üzvi — kimyəvi gübrəsiz becərilir',
                'image'       => 'https://images.unsplash.com/photo-1490818387583-1baba5e638af?w=1920&q=75',
                'button_text' => 'Üzvi Məhsulları Kəşf Et',
                'link'        => '/products?organic=1',
                'type'        => 'main_slider',
                'sort_order'  => 2,
                'is_active'   => true,
            ],
            [
                'title'       => 'Mövsüm Endirimi',
                'subtitle'    => 'Seçilmiş məhsullarda 30%-ə qədər endirim',
                'image'       => 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=1920&q=75',
                'button_text' => 'Endirimlərə Bax',
                'link'        => '/products?sort=discount',
                'type'        => 'main_slider',
                'sort_order'  => 3,
                'is_active'   => true,
            ],
        ];

        foreach ($sliders as $slider) {
            DB::table('sliders')->updateOrInsert(
                ['title' => $slider['title'], 'type' => $slider['type']],
                array_merge($slider, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
