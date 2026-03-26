<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== SELLER USERS ====================
        $sellers = [
            ['first_name' => 'Əli',   'last_name' => 'Həsənov',    'email' => 'ali@meyveterevez.az'],
            ['first_name' => 'Leyla', 'last_name' => 'Quliyeva',   'email' => 'leyla@meyveterevez.az'],
            ['first_name' => 'Murad', 'last_name' => 'Əliyev',     'email' => 'murad@meyveterevez.az'],
            ['first_name' => 'Günel', 'last_name' => 'Məmmədova',  'email' => 'gunel@meyveterevez.az'],
        ];

        $sellerIds = [];
        foreach ($sellers as $seller) {
            DB::table('users')->updateOrInsert(
                ['email' => $seller['email']],
                array_merge($seller, [
                    'password'   => Hash::make('password'),
                    'locale_code'=> 'az',
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
            $sellerIds[$seller['email']] = DB::table('users')->where('email', $seller['email'])->value('id');
        }

        // ==================== STORE PROFILES ====================
        $stores = [
            [
                'user_id'      => $sellerIds['ali@meyveterevez.az'],
                'name'         => 'Əli Ferması',
                'slug'         => 'eli-fermasi',
                'description'  => 'Bakı ətrafında 20 illik ferma. Alma, armud və üzüm ixtisaslaşması.',
                'address'      => 'Abşeron rayonu, Balaxanı kəndi',
                'phone'        => '+994501234567',
                'rating_avg'   => 4.8,
                'rating_count' => 124,
                'product_count'=> 18,
                'sale_count'   => 1230,
                'is_verified'  => true,
                'is_active'    => true,
                'approved_at'  => now(),
            ],
            [
                'user_id'      => $sellerIds['leyla@meyveterevez.az'],
                'name'         => 'Leyla Üzvi Bağı',
                'slug'         => 'leyla-uzvi-bagi',
                'description'  => 'Sertifikatlı üzvi ferma. Gübrəsiz, pestisidsiz, təbii üsullarla becərilən tərəvəzlər.',
                'address'      => 'Şamaxı rayonu',
                'phone'        => '+994551234567',
                'rating_avg'   => 4.9,
                'rating_count' => 89,
                'product_count'=> 24,
                'sale_count'   => 980,
                'is_verified'  => true,
                'is_active'    => true,
                'approved_at'  => now(),
            ],
            [
                'user_id'      => $sellerIds['murad@meyveterevez.az'],
                'name'         => 'Murad Qovun Bağçası',
                'slug'         => 'murad-qovun-bagcasi',
                'description'  => 'Şirli qovun, qarpız və bostanlar. Mövsüm məhsulları.',
                'address'      => 'Sabirabad rayonu',
                'phone'        => '+994701234567',
                'rating_avg'   => 4.6,
                'rating_count' => 56,
                'product_count'=> 12,
                'sale_count'   => 430,
                'is_verified'  => true,
                'is_active'    => true,
                'approved_at'  => now(),
            ],
            [
                'user_id'      => $sellerIds['gunel@meyveterevez.az'],
                'name'         => 'Günel Göyərti Evi',
                'slug'         => 'gunel-goyerti-evi',
                'description'  => 'Hər gün təzə biçilmiş göyərtilər: nanə, reyhan, şüyüd, keşniş və daha çox.',
                'address'      => 'Binəqədi rayonu, Bakı',
                'phone'        => '+994771234567',
                'rating_avg'   => 4.7,
                'rating_count' => 73,
                'product_count'=> 15,
                'sale_count'   => 620,
                'is_verified'  => true,
                'is_active'    => true,
                'approved_at'  => now(),
            ],
        ];

        $storeIds = [];
        foreach ($stores as $store) {
            DB::table('store_profiles')->updateOrInsert(
                ['slug' => $store['slug']],
                array_merge($store, ['created_at' => now(), 'updated_at' => now()])
            );
            $storeIds[$store['slug']] = DB::table('store_profiles')->where('slug', $store['slug'])->value('id');
        }

        // ==================== CATEGORY IDs ====================
        $cat = fn(string $slug) => DB::table('categories')->where('slug', $slug)->value('id');

        // ==================== PRODUCTS ====================
        $products = [
            // --- Fruits ---
            [
                'store' => 'eli-fermasi', 'category' => 'meyveler',
                'name' => 'Qırmızı Alma', 'slug' => 'qirmizi-alma',
                'description' => 'Abşeron bağlarından birbaşa qırmızı alma. Şirin, şirəli, vitamin C-cə zəngin.',
                'price' => 1.80, 'original_price' => 2.20, 'discount_percent' => 18,
                'unit' => 'kg', 'stock_quantity' => 500,
                'is_organic' => false, 'is_fresh_today' => true, 'is_featured' => true, 'is_top_seller' => true,
                'rating_avg' => 4.8, 'rating_count' => 64, 'sale_count' => 420,
                'image' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=400&q=75',
            ],
            [
                'store' => 'eli-fermasi', 'category' => 'alma-armud',
                'name' => 'Yaşıl Alma (Granny Smith)', 'slug' => 'yasil-alma-granny-smith',
                'description' => 'Turşməzə yaşıl alma. Salat, şirə və kompot üçün ideal.',
                'price' => 1.60, 'original_price' => null, 'discount_percent' => 0,
                'unit' => 'kg', 'stock_quantity' => 300,
                'is_organic' => false, 'is_fresh_today' => true, 'is_featured' => false, 'is_top_seller' => false,
                'rating_avg' => 4.5, 'rating_count' => 28, 'sale_count' => 180,
                'image' => 'https://images.unsplash.com/photo-1619546813926-a78fa6372cd2?w=400&q=75',
            ],
            [
                'store' => 'eli-fermasi', 'category' => 'uzum',
                'name' => 'Ağ Üzüm (Şirəli)', 'slug' => 'ag-uzum-sireli',
                'description' => 'Ləzzətli ağ süfrə üzümü. Çəyirdəksiz, incə dərili, şirin.',
                'price' => 3.20, 'original_price' => 4.00, 'discount_percent' => 20,
                'unit' => 'kg', 'stock_quantity' => 200,
                'is_organic' => true, 'is_fresh_today' => true, 'is_featured' => true, 'is_top_seller' => true,
                'rating_avg' => 4.9, 'rating_count' => 91, 'sale_count' => 560,
                'image' => 'https://images.unsplash.com/photo-1537640538966-79f369143f8f?w=400&q=75',
            ],
            [
                'store' => 'eli-fermasi', 'category' => 'uzum',
                'name' => 'Qara Üzüm (Şamaxı)', 'slug' => 'qara-uzum-samaxi',
                'description' => 'Şamaxı üzümü — zəngin ləzzəti ilə məşhur qara üzüm növü.',
                'price' => 2.80, 'original_price' => null, 'discount_percent' => 0,
                'unit' => 'kg', 'stock_quantity' => 150,
                'is_organic' => false, 'is_fresh_today' => true, 'is_featured' => false, 'is_top_seller' => true,
                'rating_avg' => 4.7, 'rating_count' => 47, 'sale_count' => 290,
                'image' => 'https://images.unsplash.com/photo-1567306301408-9b74779a11af?w=400&q=75',
            ],
            [
                'store' => 'leyla-uzvi-bagi', 'category' => 'ciy-meyveler',
                'name' => 'Çiyələk (Üzvi)', 'slug' => 'ciyerek-uzvi',
                'description' => 'Gübrəsiz becərilmiş üzvi çiyələk. Ətirli, şirin, böyük dənəli.',
                'price' => 4.50, 'original_price' => 5.50, 'discount_percent' => 18,
                'unit' => 'kg', 'stock_quantity' => 80,
                'is_organic' => true, 'is_fresh_today' => true, 'is_featured' => true, 'is_top_seller' => true,
                'rating_avg' => 5.0, 'rating_count' => 38, 'sale_count' => 210,
                'image' => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=400&q=75',
            ],
            [
                'store' => 'eli-fermasi', 'category' => 'narinci-limon',
                'name' => 'Portağal (Navel)', 'slug' => 'portaqal-navel',
                'description' => 'Şirəli navel portağal. Vitamin C mənbəyi, çəyirdəksiz.',
                'price' => 2.20, 'original_price' => null, 'discount_percent' => 0,
                'unit' => 'kg', 'stock_quantity' => 400,
                'is_organic' => false, 'is_fresh_today' => false, 'is_featured' => false, 'is_top_seller' => false,
                'rating_avg' => 4.4, 'rating_count' => 22, 'sale_count' => 145,
                'image' => 'https://images.unsplash.com/photo-1547514701-42782101795e?w=400&q=75',
            ],

            // --- Vegetables ---
            [
                'store' => 'leyla-uzvi-bagi', 'category' => 'meyve-terevezer',
                'name' => 'Pomidor (Üzvi)', 'slug' => 'pomidor-uzvi',
                'description' => 'Açıq havada becərilmiş üzvi pomidor. Qırmızı, ətli, şirəli.',
                'price' => 1.40, 'original_price' => 1.80, 'discount_percent' => 22,
                'unit' => 'kg', 'stock_quantity' => 600,
                'is_organic' => true, 'is_fresh_today' => true, 'is_featured' => true, 'is_top_seller' => true,
                'rating_avg' => 4.8, 'rating_count' => 112, 'sale_count' => 780,
                'image' => 'https://images.unsplash.com/photo-1546094096-0df4bcaaa337?w=400&q=75',
            ],
            [
                'store' => 'leyla-uzvi-bagi', 'category' => 'meyve-terevezer',
                'name' => 'Xiyar (Gülxanı)', 'slug' => 'xiyar-gulxani',
                'description' => 'Gülxanada becərilmiş xiyar. Xırtıldayan, şirin, qabıqsız.',
                'price' => 1.20, 'original_price' => null, 'discount_percent' => 0,
                'unit' => 'kg', 'stock_quantity' => 450,
                'is_organic' => false, 'is_fresh_today' => true, 'is_featured' => false, 'is_top_seller' => true,
                'rating_avg' => 4.6, 'rating_count' => 84, 'sale_count' => 620,
                'image' => 'https://images.unsplash.com/photo-1449300079323-02e209d9d3a6?w=400&q=75',
            ],
            [
                'store' => 'leyla-uzvi-bagi', 'category' => 'meyve-terevezer',
                'name' => 'Bibər (Bolqar)', 'slug' => 'biber-bolqar',
                'description' => 'Rəngli bolqar bibəri — sarı, qırmızı, yaşıl. Vitamin C anbarı.',
                'price' => 2.00, 'original_price' => 2.50, 'discount_percent' => 20,
                'unit' => 'kg', 'stock_quantity' => 300,
                'is_organic' => true, 'is_fresh_today' => true, 'is_featured' => false, 'is_top_seller' => false,
                'rating_avg' => 4.5, 'rating_count' => 35, 'sale_count' => 240,
                'image' => 'https://images.unsplash.com/photo-1563565375-f3fdfdbefa83?w=400&q=75',
            ],
            [
                'store' => 'leyla-uzvi-bagi', 'category' => 'kok-terevezer',
                'name' => 'Yerkökü (Üzvi)', 'slug' => 'yerkoky-uzvi',
                'description' => 'Şirin, iri, üzvi yerkökü. Şirə, salat və çorba üçün.',
                'price' => 0.90, 'original_price' => null, 'discount_percent' => 0,
                'unit' => 'kg', 'stock_quantity' => 700,
                'is_organic' => true, 'is_fresh_today' => false, 'is_featured' => false, 'is_top_seller' => false,
                'rating_avg' => 4.7, 'rating_count' => 56, 'sale_count' => 430,
                'image' => 'https://images.unsplash.com/photo-1445282768818-728615cc910a?w=400&q=75',
            ],
            [
                'store' => 'leyla-uzvi-bagi', 'category' => 'soganagillar',
                'name' => 'Sarımsaq (Yerli)', 'slug' => 'sarimisaq-yerli',
                'description' => 'Güclü ətirli yerli sarımsaq. Iri baş, ağ dərili.',
                'price' => 3.50, 'original_price' => 4.20, 'discount_percent' => 17,
                'unit' => 'kg', 'stock_quantity' => 200,
                'is_organic' => false, 'is_fresh_today' => false, 'is_featured' => false, 'is_top_seller' => true,
                'rating_avg' => 4.9, 'rating_count' => 67, 'sale_count' => 510,
                'image' => 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?w=400&q=75',
            ],

            // --- Melons / Watermelons ---
            [
                'store' => 'murad-qovun-bagcasi', 'category' => 'qusambaligi',
                'name' => 'Qarpız (Sabirabad)', 'slug' => 'qarpiz-sabirabad',
                'description' => 'Sabirabad qarpızı — Azərbaycanın ən məşhur qarpız növü. Şirin, qırmızı, iri.',
                'price' => 0.60, 'original_price' => null, 'discount_percent' => 0,
                'unit' => 'kg', 'stock_quantity' => 2000,
                'is_organic' => false, 'is_fresh_today' => true, 'is_featured' => true, 'is_top_seller' => true,
                'rating_avg' => 4.9, 'rating_count' => 203, 'sale_count' => 1840,
                'image' => 'https://images.unsplash.com/photo-1563114773-84221bd62daa?w=400&q=75',
            ],
            [
                'store' => 'murad-qovun-bagcasi', 'category' => 'qusambaligi',
                'name' => 'Qovun (Kolxoz Qadını)', 'slug' => 'qovun-kolxoz-qadini',
                'description' => 'Ənənəvi "Kolxoz Qadını" qovun növü. Çox şirin, ətirli, sarı qabıqlı.',
                'price' => 1.20, 'original_price' => 1.60, 'discount_percent' => 25,
                'unit' => 'kg', 'stock_quantity' => 800,
                'is_organic' => false, 'is_fresh_today' => true, 'is_featured' => true, 'is_top_seller' => true,
                'rating_avg' => 4.8, 'rating_count' => 145, 'sale_count' => 920,
                'image' => 'https://images.unsplash.com/photo-1571575173700-afb9492437c0?w=400&q=75',
            ],

            // --- Herbs ---
            [
                'store' => 'gunel-goyerti-evi', 'category' => 'goyertiler',
                'name' => 'Nanə (Təzə)', 'slug' => 'nane-teze',
                'description' => 'Hər gün biçilmiş təzə nanə. Ətirli, sağlamlıq üçün faydalı.',
                'price' => 0.50, 'original_price' => null, 'discount_percent' => 0,
                'unit' => 'piece', 'stock_quantity' => 200,
                'is_organic' => true, 'is_fresh_today' => true, 'is_featured' => false, 'is_top_seller' => false,
                'rating_avg' => 4.7, 'rating_count' => 44, 'sale_count' => 380,
                'image' => 'https://images.unsplash.com/photo-1628556270448-4d4e4148e1b1?w=400&q=75',
            ],
            [
                'store' => 'gunel-goyerti-evi', 'category' => 'goyertiler',
                'name' => 'Reyhan (Bazilika)', 'slug' => 'reyhan-bazilika',
                'description' => 'Ətirli yaşıl reyhan. Şiş, salat, souslar üçün vazkeçilməz.',
                'price' => 0.60, 'original_price' => null, 'discount_percent' => 0,
                'unit' => 'piece', 'stock_quantity' => 150,
                'is_organic' => true, 'is_fresh_today' => true, 'is_featured' => false, 'is_top_seller' => true,
                'rating_avg' => 4.8, 'rating_count' => 62, 'sale_count' => 490,
                'image' => 'https://images.unsplash.com/photo-1618375569909-3c8616cf7733?w=400&q=75',
            ],
            [
                'store' => 'gunel-goyerti-evi', 'category' => 'goyertiler',
                'name' => 'Keşniş (Cilantro)', 'slug' => 'kesnis-cilantro',
                'description' => 'Yerli keşniş göyərtisi. Plov, şorba, ətin yanına ideal.',
                'price' => 0.50, 'original_price' => null, 'discount_percent' => 0,
                'unit' => 'piece', 'stock_quantity' => 180,
                'is_organic' => false, 'is_fresh_today' => true, 'is_featured' => false, 'is_top_seller' => false,
                'rating_avg' => 4.6, 'rating_count' => 31, 'sale_count' => 270,
                'image' => 'https://images.unsplash.com/photo-1599388904938-e45e6d98f1b5?w=400&q=75',
            ],
        ];

        foreach ($products as $data) {
            $storeId    = $storeIds[$data['store']] ?? null;
            $storeUserId = $storeId ? DB::table('store_profiles')->where('id', $storeId)->value('user_id') : null;
            $categoryId = $cat($data['category']);

            unset($data['store'], $data['category'], $data['image']);

            DB::table('products')->updateOrInsert(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'user_id'          => $storeUserId,
                    'store_profile_id' => $storeId,
                    'category_id'      => $categoryId,
                    'status'           => 'active',
                    'in_stock'         => true,
                    'min_order_qty'    => 1,
                    'max_order_qty'    => null,
                    'views_count'      => rand(50, 500),
                    'meta_title'       => null,
                    'meta_description' => null,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ])
            );
        }

        // ==================== PRODUCT IMAGES (Unsplash) ====================
        $images = [
            'qirmizi-alma'         => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=600&q=75',
            'yasil-alma-granny-smith'=> 'https://images.unsplash.com/photo-1619546813926-a78fa6372cd2?w=600&q=75',
            'ag-uzum-sireli'       => 'https://images.unsplash.com/photo-1537640538966-79f369143f8f?w=600&q=75',
            'qara-uzum-samaxi'     => 'https://images.unsplash.com/photo-1567306301408-9b74779a11af?w=600&q=75',
            'ciyerek-uzvi'         => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=600&q=75',
            'portaqal-navel'       => 'https://images.unsplash.com/photo-1547514701-42782101795e?w=600&q=75',
            'pomidor-uzvi'         => 'https://images.unsplash.com/photo-1546094096-0df4bcaaa337?w=600&q=75',
            'xiyar-gulxani'        => 'https://images.unsplash.com/photo-1449300079323-02e209d9d3a6?w=600&q=75',
            'biber-bolqar'         => 'https://images.unsplash.com/photo-1563565375-f3fdfdbefa83?w=600&q=75',
            'yerkoky-uzvi'         => 'https://images.unsplash.com/photo-1445282768818-728615cc910a?w=600&q=75',
            'sarimisaq-yerli'      => 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?w=600&q=75',
            'qarpiz-sabirabad'     => 'https://images.unsplash.com/photo-1563114773-84221bd62daa?w=600&q=75',
            'qovun-kolxoz-qadini'  => 'https://images.unsplash.com/photo-1571575173700-afb9492437c0?w=600&q=75',
            'nane-teze'            => 'https://images.unsplash.com/photo-1628556270448-4d4e4148e1b1?w=600&q=75',
            'reyhan-bazilika'      => 'https://images.unsplash.com/photo-1618375569909-3c8616cf7733?w=600&q=75',
            'kesnis-cilantro'      => 'https://images.unsplash.com/photo-1599388904938-e45e6d98f1b5?w=600&q=75',
        ];

        foreach ($images as $slug => $url) {
            $productId = DB::table('products')->where('slug', $slug)->value('id');
            if (! $productId) {
                continue;
            }

            DB::table('product_images')->updateOrInsert(
                ['product_id' => $productId, 'is_primary' => true],
                [
                    'product_id'     => $productId,
                    'image_path'     => $url,
                    'thumbnail_path' => $url,
                    'alt'            => DB::table('products')->where('id', $productId)->value('name'),
                    'is_primary'     => true,
                    'sort_order'     => 0,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]
            );
        }
    }
}
