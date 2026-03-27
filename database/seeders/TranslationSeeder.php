<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Translation;
use App\Services\TranslationService;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        // Format: 'group.key' => ['az' => '...', 'en' => '...']
        $data = [

            // ── nav ───────────────────────────────────────────────────────
            'nav.home'           => ['az' => 'Ana Səhifə',         'en' => 'Home'],
            'nav.categories'     => ['az' => 'Kateqoriyalar',      'en' => 'Categories'],
            'nav.products'       => ['az' => 'Məhsullar',          'en' => 'Products'],
            'nav.stores'         => ['az' => 'Mağazalar',          'en' => 'Stores'],
            'nav.map'            => ['az' => 'Xəritə',             'en' => 'Map'],
            'nav.sign_in'        => ['az' => 'Daxil ol',           'en' => 'Sign In'],
            'nav.register'       => ['az' => 'Qeydiyyat',          'en' => 'Register'],
            'nav.my_profile'     => ['az' => 'Profilim',           'en' => 'My Profile'],
            'nav.my_orders'      => ['az' => 'Sifarişlərim',       'en' => 'My Orders'],
            'nav.favorites'      => ['az' => 'Sevimlilər',         'en' => 'Favorites'],
            'nav.my_stores'      => ['az' => 'Mağazalarım',        'en' => 'My Stores'],
            'nav.sign_out'       => ['az' => 'Çıxış',              'en' => 'Sign Out'],
            'nav.menu'           => ['az' => 'Menyu',              'en' => 'Menu'],
            'nav.language'       => ['az' => 'Dil',                'en' => 'Language'],
            'nav.admin_panel'    => ['az' => 'Admin Panel',       'en' => 'Admin Panel'],

            // ── button ────────────────────────────────────────────────────
            'button.add_to_cart'       => ['az' => 'Səbətə əlavə et',       'en' => 'Add to Cart'],
            'button.checkout'          => ['az' => 'Sifarişi tamamla',       'en' => 'Proceed to Checkout'],
            'button.continue_shopping' => ['az' => 'Alış-verişə davam et',  'en' => 'Continue Shopping'],
            'button.apply_filters'     => ['az' => 'Filtrləri tətbiq et',   'en' => 'Apply Filters'],
            'button.apply'             => ['az' => 'Tətbiq et',             'en' => 'Apply'],
            'button.reset'             => ['az' => 'Sıfırla',               'en' => 'Reset'],
            'button.reset_all'         => ['az' => 'Hamısını sıfırla',      'en' => 'Reset All'],
            'button.load_more'         => ['az' => 'Daha çox',              'en' => 'Load More'],
            'button.subscribe'         => ['az' => 'Abunə ol',              'en' => 'Subscribe'],
            'button.shop_now'          => ['az' => 'İndi al',               'en' => 'Shop Now'],
            'button.explore_fruits'    => ['az' => 'Meyvələri kəşf et',     'en' => 'Explore Fruits'],
            'button.browse_stores'     => ['az' => 'Mağazalara bax',        'en' => 'Browse Stores'],
            'button.view_all'          => ['az' => 'Hamısına bax',          'en' => 'View all'],
            'button.view_all_stores'   => ['az' => 'Bütün mağazalar',       'en' => 'View all stores'],
            'button.view_all_products' => ['az' => 'Bütün məhsullar',       'en' => 'View All Products'],
            'button.browse_all'        => ['az' => 'Bütün məhsullara bax',  'en' => 'Browse All Products'],

            // ── label ─────────────────────────────────────────────────────
            'label.search_placeholder'        => ['az' => 'Meyvə, tərəvəz, mağaza axtar...',   'en' => 'Search for fruits, vegetables, stores...'],
            'label.search_mobile_placeholder' => ['az' => 'Məhsul, mağaza axtar...',           'en' => 'Search products, stores...'],
            'label.filters'                   => ['az' => 'Filtrlər',                          'en' => 'Filters'],
            'label.refine_results'            => ['az' => 'Nəticələri dəqiqləşdir',            'en' => 'Refine Results'],
            'label.category'                  => ['az' => 'Kateqoriya',                        'en' => 'Category'],
            'label.subcategory'               => ['az' => 'Alt kateqoriya',                    'en' => 'Subcategory'],
            'label.price_range'               => ['az' => 'Qiymət aralığı',                   'en' => 'Price Range'],
            'label.min_rating'                => ['az' => 'Min. Reytinq',                      'en' => 'Min. Rating'],
            'label.attributes'                => ['az' => 'Xüsusiyyətlər',                     'en' => 'Attributes'],
            'label.store_type'                => ['az' => 'Mağaza növü',                       'en' => 'Store Type'],
            'label.organic'                   => ['az' => 'Üzvi',                              'en' => 'Organic'],
            'label.fresh_today'               => ['az' => 'Bu gün təzə',                       'en' => 'Fresh Today'],
            'label.in_stock_only'             => ['az' => 'Yalnız stokda',                     'en' => 'In Stock Only'],
            'label.in_stock'                  => ['az' => 'Stokda var',                        'en' => 'In Stock'],
            'label.out_of_stock'              => ['az' => 'Stokda yoxdur',                     'en' => 'Out of Stock'],
            'label.locally_grown'             => ['az' => 'Yerli yetişdirilmiş',               'en' => 'Locally Grown'],
            'label.seasonal'                  => ['az' => 'Mövsümi',                           'en' => 'Seasonal'],
            'label.all'                       => ['az' => 'Hamısı',                            'en' => 'All'],
            'label.new_arrivals'              => ['az' => 'Yeni gəlişlər',                     'en' => 'New Arrivals'],
            'label.local_sellers'             => ['az' => 'Yerli satıcılar',                   'en' => 'Local Sellers'],
            'label.products_found'            => ['az' => 'məhsul tapıldı',                    'en' => 'products found'],
            'label.sold_by'                   => ['az' => 'Satıcı',                            'en' => 'Sold by'],
            'label.best_price'                => ['az' => 'Ən yaxşı qiymət',                   'en' => 'Best Price'],
            'label.seller'                    => ['az' => 'Satıcı',                            'en' => 'Seller'],
            'label.price'                     => ['az' => 'Qiymət',                            'en' => 'Price'],
            'label.rating'                    => ['az' => 'Reytinq',                           'en' => 'Rating'],
            'label.delivery'                  => ['az' => 'Çatdırılma',                        'en' => 'Delivery'],
            'label.unavailable'               => ['az' => 'Mövcud deyil',                      'en' => 'Unavailable'],
            'label.select_unit'               => ['az' => 'Vahid seçin',                       'en' => 'Select Unit'],
            'label.and_up'                    => ['az' => 'və yuxarı',                         'en' => '& up'],
            'label.off'                       => ['az' => 'endirim',                           'en' => 'off'],
            'label.reviews'                   => ['az' => 'rəy',                               'en' => 'reviews'],
            'label.email_placeholder'         => ['az' => 'E-poçtunuzu daxil edin',            'en' => 'Enter your email'],
            'label.farm_direct'               => ['az' => 'Fermadan birbaşa',                  'en' => 'Farm Direct'],
            'label.organic_shop'              => ['az' => 'Üzvi mağaza',                       'en' => 'Organic Shop'],
            'label.grocery_store'             => ['az' => 'Bakkaliyyə',                        'en' => 'Grocery Store'],
            'label.wholesale'                 => ['az' => 'Topdan',                            'en' => 'Wholesale'],

            // ── sort ──────────────────────────────────────────────────────
            'sort.default'     => ['az' => 'Standart',                   'en' => 'Default'],
            'sort.price_asc'   => ['az' => 'Qiymət: Aşağıdan yuxarıya', 'en' => 'Price: Low to High'],
            'sort.price_desc'  => ['az' => 'Qiymət: Yuxarıdan aşağıya', 'en' => 'Price: High to Low'],
            'sort.top_rated'   => ['az' => 'Ən yüksək reytinqli',       'en' => 'Top Rated'],
            'sort.newest'      => ['az' => 'Ən yenisi',                  'en' => 'Newest'],
            'sort.discount'    => ['az' => 'Endirim',                    'en' => 'Discount'],
            'sort.relevance'   => ['az' => 'Uyğunluq',                  'en' => 'Relevance'],

            // ── heading ───────────────────────────────────────────────────
            'heading.shop_by_category'       => ['az' => 'Kateqoriyaya görə al',                             'en' => 'Shop by Category'],
            'heading.popular_stores'         => ['az' => 'Məşhur mağazalar',                                  'en' => 'Popular Stores'],
            'heading.popular_stores_desc'    => ['az' => 'Yaxınlığınızdakı ən yüksək reytinqli satıcılar',   'en' => 'Shop from top-rated local sellers near you'],
            'heading.featured_products'      => ['az' => 'Seçilmiş məhsullar',                                'en' => 'Featured Products'],
            'heading.featured_products_desc' => ['az' => 'Yerli satıcıların əl seçmə məhsulları',            'en' => 'Handpicked favourites from local sellers'],
            'heading.stay_updated'           => ['az' => 'Xəbərdar ol',                                       'en' => 'Stay Updated'],
            'heading.stay_updated_desc'      => ['az' => 'Bölgənizdəki yeni məhsullar və xüsusi təkliflər haqqında xəbərdar olun.', 'en' => 'Get notified about new products and special offers in your area.'],
            'heading.all_products'           => ['az' => 'Bütün Məhsullar',                                   'en' => 'All Products'],
            'heading.all_products_desc'      => ['az' => 'Yerli satıcılardan təzə məhsullar',                 'en' => 'Fresh produce from local sellers'],
            'heading.compare_sellers'        => ['az' => 'Satıcıları müqayisə et',                            'en' => 'Compare Sellers'],
            'heading.related_products'       => ['az' => 'Əlaqəli məhsullar',                                 'en' => 'Related Products'],

            // ── value_prop ────────────────────────────────────────────────
            'value_prop.fast_delivery'         => ['az' => 'Sürətli çatdırılma',      'en' => 'Fast Delivery'],
            'value_prop.fast_delivery_desc'    => ['az' => 'Təzə məhsullar qapınıza', 'en' => 'Fresh produce to your door'],
            'value_prop.cash_on_delivery'      => ['az' => 'Çatdırılmada nağd',       'en' => 'Cash on Delivery'],
            'value_prop.cash_on_delivery_desc' => ['az' => 'Alanda ödə',              'en' => 'Pay when you receive'],
            'value_prop.local_sellers'         => ['az' => 'Yerli satıcılar',         'en' => 'Local Sellers'],
            'value_prop.local_sellers_desc'    => ['az' => 'Yalnız öz ölkənizdən',    'en' => 'From your country only'],
            'value_prop.fresh_organic'         => ['az' => 'Təzə və Üzvi',            'en' => 'Fresh & Organic'],
            'value_prop.fresh_organic_desc'    => ['az' => 'Keyfiyyət zəmanətlidir',  'en' => 'Quality guaranteed'],

            // ── cart ──────────────────────────────────────────────────────
            'cart.title'        => ['az' => 'Səbətiniz',                      'en' => 'Your Cart'],
            'cart.empty'        => ['az' => 'Səbətiniz boşdur',               'en' => 'Your cart is empty'],
            'cart.subtotal'     => ['az' => 'Aralıq cəm',                     'en' => 'Subtotal'],
            'cart.total'        => ['az' => 'Cəmi',                           'en' => 'Total'],
            'cart.payment_note' => ['az' => 'Ödəniş: Çatdırılmada nağd',     'en' => 'Payment: Cash on Delivery'],

            // ── footer ────────────────────────────────────────────────────
            'footer.company_desc'     => ['az' => 'Etibar etdiyiniz bazar yeri — təzə meyvə, tərəvəz və yerli məhsullar birbaşa satıcılardan qapınıza.', 'en' => 'Your trusted marketplace for fresh fruits, vegetables and local produce — straight from local sellers to your door.'],
            'footer.quick_links'      => ['az' => 'Sürətli keçidlər',     'en' => 'Quick Links'],
            'footer.customer_service' => ['az' => 'Müştəri xidməti',      'en' => 'Customer Service'],
            'footer.contact'          => ['az' => 'Bizimlə əlaqə',        'en' => 'Contact Us'],
            'footer.help_center'      => ['az' => 'Kömək mərkəzi',        'en' => 'Help Center'],
            'footer.track_order'      => ['az' => 'Sifarişi izlə',        'en' => 'Track Order'],
            'footer.faq'              => ['az' => 'TSS',                   'en' => 'FAQ'],
            'footer.privacy'          => ['az' => 'Məxfilik siyasəti',    'en' => 'Privacy Policy'],
            'footer.terms'            => ['az' => 'İstifadə şərtləri',    'en' => 'Terms of Service'],
            'footer.payment_label'    => ['az' => 'Ödəniş',               'en' => 'Payment'],
            'footer.rights'           => ['az' => 'Bütün hüquqlar qorunur.', 'en' => 'All rights reserved.'],

            // ── filter ────────────────────────────────────────────────────
            'filter.fruits'      => ['az' => 'Meyvələr',        'en' => 'Fruits'],
            'filter.vegetables'  => ['az' => 'Tərəvəzlər',      'en' => 'Vegetables'],
            'filter.dairy'       => ['az' => 'Süd məhsulları',  'en' => 'Dairy'],
            'filter.bakery'      => ['az' => 'Çörəkçilik',      'en' => 'Bakery'],
            'filter.meat'        => ['az' => 'Ət',              'en' => 'Meat'],
            'filter.beverages'   => ['az' => 'İçkilər',         'en' => 'Beverages'],

            // ── search ────────────────────────────────────────────────────
            'search.results_for'      => ['az' => 'Üçün nəticələr',                                            'en' => 'Results for'],
            'search.no_results_title' => ['az' => 'Məhsul tapılmadı',                                          'en' => 'No products found'],
            'search.no_results_desc'  => ['az' => 'Fərqli açar sözlər sınayın və ya bəzi filtrləri silin.',    'en' => 'Try different keywords or remove some filters.'],
            'search.what_looking_for' => ['az' => 'Nə axtarırsınız?',                                          'en' => 'What are you looking for?'],
            'search.enter_keyword'    => ['az' => 'Axtarmaq üçün açar söz daxil edin',                         'en' => 'Enter a keyword to search'],

            // ── carousel ──────────────────────────────────────────────────
            'carousel.slide1_tag'    => ['az' => 'Bu gün təzə',                                                     'en' => 'Fresh Today'],
            'carousel.slide1_title'  => ['az' => 'Təzə Üzvi Tərəvəzlər',                                           'en' => 'Fresh Organic Vegetables'],
            'carousel.slide1_sub'    => ['az' => 'Fermalardan birbaşa',                                             'en' => 'Direct from Farms'],
            'carousel.slide1_desc'   => ['az' => 'Yerli satıcılardan təzə məhsulları birbaşa qapınıza çatdırın.',  'en' => 'Get fresh produce delivered straight from local sellers to your doorstep.'],
            'carousel.slide2_tag'    => ['az' => 'Yeni gəlişlər',                                                   'en' => 'New Arrivals'],
            'carousel.slide2_title'  => ['az' => 'Premium Meyvələr',                                               'en' => 'Premium Fruits'],
            'carousel.slide2_sub'    => ['az' => 'Kolleksiya',                                                      'en' => 'Collection'],
            'carousel.slide2_desc'   => ['az' => 'Bölgənizdə yerli satıcıların əl ilə seçilmiş mövsümi meyvələri.', 'en' => 'Handpicked seasonal fruits from local sellers across your region.'],
            'carousel.slide3_tag'    => ['az' => 'Yerli Satıcılar',                                                 'en' => 'Local Sellers'],
            'carousel.slide3_title'  => ['az' => 'Yerlini dəstəklə',                                               'en' => 'Support Local'],
            'carousel.slide3_sub'    => ['az' => 'Fermerlər və Satıcılar',                                          'en' => 'Farmers & Sellers'],
            'carousel.slide3_desc'   => ['az' => 'Təsdiqlənmiş yerli satıcılardan birbaşa alın. Çatdırılmada nağd ödəyin.', 'en' => 'Buy directly from verified local sellers. Pay cash on delivery.'],

            // ── product_detail ────────────────────────────────────────────
            'product_detail.tab_description' => ['az' => 'Təsvir',          'en' => 'Description'],
            'product_detail.tab_reviews'     => ['az' => 'Rəylər',          'en' => 'Reviews'],
            'product_detail.tab_nutrition'   => ['az' => 'Qida dəyəri',     'en' => 'Nutrition'],
            'product_detail.usda_certified'  => ['az' => 'USDA Üzvi Sertifikatlı', 'en' => 'USDA Organic Certified'],
            'product_detail.no_preservatives'=> ['az' => 'Süni qoruyucu yoxdur',   'en' => 'No artificial preservatives'],
            'product_detail.locally_sourced' => ['az' => 'Yerli mənbəli',          'en' => 'Locally sourced'],
            'product_detail.harvested_fresh' => ['az' => 'Hər gün təzə toplanır',  'en' => 'Harvested fresh daily'],
            'product_detail.calories'        => ['az' => 'Kalori',     'en' => 'Calories'],
            'product_detail.carbs'           => ['az' => 'Karbohidrat','en' => 'Carbs'],
            'product_detail.fiber'           => ['az' => 'Lif',        'en' => 'Fiber'],
            'product_detail.vitamin_c'       => ['az' => 'Vitamin C',  'en' => 'Vitamin C'],

            // ── breadcrumb ────────────────────────────────────────────────
            'breadcrumb.home'           => ['az' => 'Ana Səhifə',  'en' => 'Home'],
            'breadcrumb.products'       => ['az' => 'Məhsullar', 'en' => 'Products'],
            'breadcrumb.search'         => ['az' => 'Axtarış',   'en' => 'Search'],
            'breadcrumb.product_detail' => ['az' => 'Məhsul',    'en' => 'Product'],

            // ── product (meta) ────────────────────────────────────────────
            'product.detail_title' => ['az' => 'Məhsul Təfərrüatı',                                                          'en' => 'Product Detail'],
            'product.detail_desc'  => ['az' => 'Yerli satıcılardan təzə məhsullar — təfərrüatları görün, satıcıları müqayisə edin', 'en' => 'Fresh produce from local sellers — view details, compare sellers and add to cart'],

            // ── label (product detail extras) ─────────────────────────────
            'label.product_image' => ['az' => 'Məhsul şəkli',   'en' => 'Product Image'],
            'label.thumbnail'     => ['az' => 'Kiçik şəkil',    'en' => 'Thumbnail'],
            'label.sales'         => ['az' => 'satış',          'en' => 'sales'],
            'label.stock'         => ['az' => 'Stok',           'en' => 'Stock'],

            // ── button (product detail extras) ────────────────────────────
            'button.view_store'   => ['az' => 'Mağazaya bax',   'en' => 'View Store'],

            // ── tab ───────────────────────────────────────────────────────
            'tab.description'     => ['az' => 'Təsvir',         'en' => 'Description'],
            'tab.reviews'         => ['az' => 'Rəylər',         'en' => 'Reviews'],
            'tab.nutrition'       => ['az' => 'Qidalanma',      'en' => 'Nutrition'],

            // ── product_detail (organic badge) ────────────────────────────
            'product_detail.organic_certified' => ['az' => 'USDA Üzvi Sertifikatı', 'en' => 'USDA Organic Certified'],

            // ── message ───────────────────────────────────────────────────
            'message.added_to_cart' => ['az' => 'Səbətə əlavə edildi', 'en' => 'Added to cart'],

            // ── search (extra keys) ───────────────────────────────────────
            'search.title'          => ['az' => 'Axtarış',                        'en' => 'Search'],
            'search.empty_hint'     => ['az' => 'Axtarmaq istədiyinizi daxil edin','en' => 'Enter what you\'re looking for'],
            'search.no_results'     => ['az' => 'Nəticə tapılmadı',               'en' => 'No results found'],
            'search.no_results_hint'=> ['az' => 'Fərqli açar söz sınayın',        'en' => 'Try a different keyword'],
            'search.use_bar_hint'   => ['az' => 'Yuxarıdakı axtarış çubuğundan istifadə edin', 'en' => 'Use the search bar above'],

            // ── toast ─────────────────────────────────────────────────────
            'toast.success'       => ['az' => 'Uğurlu',         'en' => 'Success'],
            'toast.error'         => ['az' => 'Xəta',           'en' => 'Error'],
            'toast.info'          => ['az' => 'Məlumat',        'en' => 'Info'],
            'toast.warning'       => ['az' => 'Xəbərdarlıq',   'en' => 'Warning'],
            'toast.added_to_cart' => ['az' => 'Səbətə əlavə edildi', 'en' => 'Added to cart'],

            // ── heading (new sections) ────────────────────────────────────────
            'heading.top_sellers'      => ['az' => 'Ən çox satılanlar',               'en' => 'Top Sellers'],
            'heading.top_sellers_desc' => ['az' => 'Müştərilərin ən çox sevdiyi məhsullar', 'en' => 'Products loved most by our customers'],
            'heading.hot_deals'        => ['az' => 'İsti təkliflər',                  'en' => 'Hot Deals'],
            'heading.hot_deals_desc'   => ['az' => 'Məhdud müddətli endirimlər',      'en' => 'Limited-time discounts'],

            // ── label (store & UI) ────────────────────────────────────────────
            'label.verified'          => ['az' => 'Təsdiqlənib',           'en' => 'Verified'],
            'label.products'          => ['az' => 'məhsul',                'en' => 'products'],
            'label.subcategories'     => ['az' => 'alt kateqoriya',        'en' => 'subcategories'],
            'label.stores_found'      => ['az' => 'mağaza tapıldı',        'en' => 'stores found'],
            'label.viewing_now'       => ['az' => 'İndi baxırsınız',       'en' => 'Viewing now'],
            'label.selected'          => ['az' => 'Seçilmiş',              'en' => 'Selected'],
            'label.anonymous'         => ['az' => 'Anonim',                'en' => 'Anonymous'],

            // ── button (extra) ─────────────────────────────────────────────────
            'button.view'             => ['az' => 'Bax',                   'en' => 'View'],

            // ── message (favorites) ───────────────────────────────────────────
            'message.added_to_favorites'     => ['az' => 'Sevimlilərə əlavə edildi', 'en' => 'Added to favorites'],
            'message.removed_from_favorites' => ['az' => 'Sevimlilərdən silindi',    'en' => 'Removed from favorites'],

            // ── auth ──────────────────────────────────────────────────────────
            'auth.login'                    => ['az' => 'Daxil ol',                          'en' => 'Login'],
            'auth.register'                 => ['az' => 'Qeydiyyat',                         'en' => 'Register'],
            'auth.welcome_back'             => ['az' => 'Xoş gəldiniz!',                     'en' => 'Welcome back!'],
            'auth.login_subtitle'           => ['az' => 'Hesabınıza daxil olmaq üçün məlumatlarınızı daxil edin', 'en' => 'Enter your details to access your account'],
            'auth.create_account'           => ['az' => 'Hesab yaradın',                     'en' => 'Create an account'],
            'auth.register_subtitle'        => ['az' => 'Qoşulun və yerli satıcılardan alış-veriş edin',        'en' => 'Join and shop from local sellers'],
            'auth.brand_headline'           => ['az' => 'Yerli satıcılardan təzə məhsullar', 'en' => 'Fresh produce from local sellers'],
            'auth.brand_sub'                => ['az' => 'Bölgənizdəki təsdiqlənmiş satıcılardan birbaşa alın.', 'en' => 'Buy directly from verified sellers in your area.'],
            'auth.register_headline'        => ['az' => 'Bizimlə alış-verişə başlayın',      'en' => 'Start shopping with us'],
            'auth.register_sub'             => ['az' => 'Pulsuz qeydiyyatdan keçin və minlərlə məhsula çıxış əldə edin.', 'en' => 'Register for free and get access to thousands of products.'],
            'auth.email'                    => ['az' => 'E-poçt ünvanı',                     'en' => 'Email address'],
            'auth.email_placeholder'        => ['az' => 'sizin@email.com',                   'en' => 'you@email.com'],
            'auth.password'                 => ['az' => 'Şifrə',                             'en' => 'Password'],
            'auth.password_placeholder'     => ['az' => 'Şifrənizi daxil edin',              'en' => 'Enter your password'],
            'auth.confirm_password'         => ['az' => 'Şifrəni təsdiqləyin',               'en' => 'Confirm password'],
            'auth.confirm_password_placeholder' => ['az' => 'Şifrəni yenidən daxil edin',   'en' => 'Re-enter your password'],
            'auth.first_name'               => ['az' => 'Ad',                                'en' => 'First name'],
            'auth.first_name_placeholder'   => ['az' => 'Adınız',                            'en' => 'Your first name'],
            'auth.last_name'                => ['az' => 'Soyad',                             'en' => 'Last name'],
            'auth.last_name_placeholder'    => ['az' => 'Soyadınız',                         'en' => 'Your last name'],
            'auth.phone'                    => ['az' => 'Telefon',                           'en' => 'Phone'],
            'auth.phone_placeholder'        => ['az' => 'XX XXX XX XX',                       'en' => 'XX XXX XX XX'],
            'auth.phone_no_leading_zero'    => ['az' => 'Ölkə kodundan sonra 0 yazılmır — nömrəni birbaşa daxil edin', 'en' => 'No leading 0 after country code — enter number directly'],
            'auth.remember_me'              => ['az' => 'Məni xatırla',                      'en' => 'Remember me'],
            'auth.forgot_password'          => ['az' => 'Şifrəni unutmusan?',                'en' => 'Forgot password?'],
            'auth.sign_in'                  => ['az' => 'Daxil ol',                          'en' => 'Sign in'],
            'auth.sign_up'                  => ['az' => 'Qeydiyyatdan keç',                  'en' => 'Sign up'],
            'auth.or'                       => ['az' => 'və ya',                             'en' => 'or'],
            'auth.no_account'               => ['az' => 'Hesabınız yoxdur?',                 'en' => "Don't have an account?"],
            'auth.have_account'             => ['az' => 'Artıq hesabınız var?',              'en' => 'Already have an account?'],
            'auth.agree_terms_prefix'       => ['az' => 'Qeydiyyatdan keçməklə siz bizim',  'en' => 'By registering you agree to our'],
            'auth.agree_terms_and'          => ['az' => 'və',                                'en' => 'and'],
            'auth.perk_fast'                => ['az' => 'Sürətli çatdırılma',               'en' => 'Fast delivery'],
            'auth.perk_fast_desc'           => ['az' => 'Sifarişiniz 30-90 dəqiqə ərzində', 'en' => 'Your order within 30-90 minutes'],
            'auth.perk_secure'              => ['az' => 'Təhlükəsiz alış-veriş',            'en' => 'Secure shopping'],
            'auth.perk_secure_desc'         => ['az' => 'Məlumatlarınız qorunur',           'en' => 'Your data is protected'],
            'auth.perk_sellers'             => ['az' => 'Minlərlə satıcı',                  'en' => 'Thousands of sellers'],
            'auth.perk_sellers_desc'        => ['az' => 'Bölgənizdəki ən yaxşı satıcılar', 'en' => 'Best sellers in your area'],
            'auth.perk_offers'              => ['az' => 'Xüsusi təkliflər',                 'en' => 'Special offers'],
            'auth.perk_offers_desc'         => ['az' => 'Endirimlər yalnız üzvlər üçün',   'en' => 'Discounts for members only'],

            // ── error ─────────────────────────────────────────────────────────
            'error.invalid_credentials'     => ['az' => 'E-poçt və ya şifrə yanlışdır',    'en' => 'Invalid email or password'],

            // ── label (extra) ─────────────────────────────────────────────────
            'label.optional'                => ['az' => 'istəyə bağlı',                     'en' => 'optional'],
            'label.name'                    => ['az' => 'Ad',                                'en' => 'Name'],

            // ── button (extra) ────────────────────────────────────────────────
            'button.save'                   => ['az' => 'Saxla',                             'en' => 'Save'],
            'button.save_changes'           => ['az' => 'Dəyişiklikləri saxla',             'en' => 'Save Changes'],
            'button.cancel'                 => ['az' => 'Ləğv et',                          'en' => 'Cancel'],
            'button.edit'                   => ['az' => 'Düzəliş et',                       'en' => 'Edit'],
            'button.delete'                 => ['az' => 'Sil',                              'en' => 'Delete'],

            // ── auth (extra) ──────────────────────────────────────────────────
            'auth.sign_out'                 => ['az' => 'Çıxış',                            'en' => 'Sign Out'],
            'auth.country'                  => ['az' => 'Ölkə',                             'en' => 'Country'],
            'auth.city'                     => ['az' => 'Şəhər',                            'en' => 'City'],
            'auth.select_country'           => ['az' => 'Ölkə seçin',                       'en' => 'Select country'],
            'auth.select_city'              => ['az' => 'Şəhər seçin',                      'en' => 'Select city'],
            'auth.phone_code'               => ['az' => 'Ölkə kodu',                        'en' => 'Phone code'],

            // ── enum ──────────────────────────────────────────────────────────
            'enum.role.user'                => ['az' => 'İstifadəçi',                       'en' => 'User'],
            'enum.role.admin'               => ['az' => 'Admin',                            'en' => 'Admin'],

            // ── admin ─────────────────────────────────────────────────────────
            'admin.panel'                   => ['az' => 'İdarəetmə Paneli',                 'en' => 'Admin Panel'],
            'admin.dashboard'               => ['az' => 'İdarə Paneli',                     'en' => 'Dashboard'],
            'admin.view_site'               => ['az' => 'Saytı gör',                        'en' => 'View Site'],

            // admin nav
            'admin.nav_general'             => ['az' => 'Ümumi',                            'en' => 'General'],
            'admin.nav_catalog'             => ['az' => 'Kataloq',                          'en' => 'Catalog'],
            'admin.nav_dashboard'           => ['az' => 'Əsas səhifə',                      'en' => 'Dashboard'],
            'admin.nav_locations'           => ['az' => 'Yerlər',                           'en' => 'Locations'],
            'admin.nav_phone_codes'         => ['az' => 'Telefon kodları',                  'en' => 'Phone Codes'],

            // admin stats
            'admin.stat_users'              => ['az' => 'İstifadəçilər',                    'en' => 'Users'],
            'admin.stat_locations'          => ['az' => 'Yerlər',                           'en' => 'Locations'],
            'admin.stat_countries'          => ['az' => 'Ölkələr',                          'en' => 'Countries'],
            'admin.stat_codes'              => ['az' => 'Telefon kodları',                  'en' => 'Phone Codes'],

            // admin quick actions
            'admin.quick_actions'           => ['az' => 'Sürətli əməliyyatlar',             'en' => 'Quick Actions'],
            'admin.add_location'            => ['az' => 'Yer əlavə et',                     'en' => 'Add Location'],
            'admin.add_location_desc'       => ['az' => 'Ölkə və ya şəhər əlavə et',       'en' => 'Add a country or city'],
            'admin.add_phone_code'          => ['az' => 'Telefon kodu əlavə et',            'en' => 'Add Phone Code'],
            'admin.add_phone_code_desc'     => ['az' => 'Yeni ölkə telefon kodu',           'en' => 'New country phone code'],
            'admin.location_breakdown'      => ['az' => 'Yer statistikası',                 'en' => 'Location Breakdown'],
            'admin.countries'               => ['az' => 'Ölkələr',                          'en' => 'Countries'],
            'admin.cities'                  => ['az' => 'Şəhərlər',                         'en' => 'Cities'],

            // admin table columns
            'admin.col_type'                => ['az' => 'Növ',                              'en' => 'Type'],
            'admin.col_parent'              => ['az' => 'Üst yer',                          'en' => 'Parent'],
            'admin.col_code'                => ['az' => 'Kod',                              'en' => 'Code'],
            'admin.col_status'              => ['az' => 'Status',                           'en' => 'Status'],
            'admin.col_actions'             => ['az' => 'Əməliyyatlar',                     'en' => 'Actions'],
            'admin.col_phone_code'          => ['az' => 'Telefon kodu',                     'en' => 'Phone Code'],
            'admin.col_native_name'         => ['az' => 'Doğma dil adı',                   'en' => 'Native Name'],
            'admin.col_trunk_prefix'        => ['az' => 'Trunk prefiks',                    'en' => 'Trunk Prefix'],
            'admin.col_idd_prefix'          => ['az' => 'IDD prefiks',                      'en' => 'IDD Prefix'],
            'admin.col_latitude'            => ['az' => 'Enlik',                            'en' => 'Latitude'],
            'admin.col_longitude'           => ['az' => 'Uzunluq',                          'en' => 'Longitude'],
            'admin.col_status_active'       => ['az' => 'Aktiv',                            'en' => 'Active'],

            // admin location types
            'admin.type_country'            => ['az' => 'Ölkə',                             'en' => 'Country'],
            'admin.type_state'              => ['az' => 'Vilayət',                          'en' => 'State'],
            'admin.type_city'               => ['az' => 'Şəhər',                            'en' => 'City'],

            // admin form labels / hints
            'admin.select_country'          => ['az' => 'Ölkə seçin',                      'en' => 'Select Country'],
            'admin.location_name_placeholder' => ['az' => 'Məs: Azərbaycan',              'en' => 'e.g. Azerbaijan'],
            'admin.code_hint'               => ['az' => 'ISO 3166-1 alfa-2',               'en' => 'ISO 3166-1 alpha-2'],
            'admin.in_english'              => ['az' => 'İngiliscə',                        'en' => 'In English'],

            // admin messages
            'admin.location_created'        => ['az' => 'Yer uğurla əlavə edildi',         'en' => 'Location created successfully'],
            'admin.location_updated'        => ['az' => 'Yer uğurla yeniləndi',            'en' => 'Location updated successfully'],
            'admin.location_deleted'        => ['az' => 'Yer uğurla silindi',              'en' => 'Location deleted successfully'],
            'admin.location_has_children'   => ['az' => 'Bu yerin alt yerləri var',        'en' => 'This location has child entries'],
            'admin.location_has_users'      => ['az' => 'Bu yer istifadəçilərə bağlıdır', 'en' => 'This location is linked to users'],
            'admin.phone_code_created'      => ['az' => 'Telefon kodu əlavə edildi',       'en' => 'Phone code created successfully'],
            'admin.phone_code_updated'      => ['az' => 'Telefon kodu yeniləndi',          'en' => 'Phone code updated successfully'],
            'admin.phone_code_deleted'      => ['az' => 'Telefon kodu silindi',            'en' => 'Phone code deleted successfully'],
            'admin.no_locations'            => ['az' => 'Heç bir yer tapılmadı',           'en' => 'No locations found'],
            'admin.no_phone_codes'          => ['az' => 'Heç bir telefon kodu tapılmadı', 'en' => 'No phone codes found'],
            'admin.confirm_delete'          => ['az' => 'Silmək istədiyinizə əminsiniz?',  'en' => 'Are you sure you want to delete this?'],
            'admin.total_records'           => ['az' => ':count qeyd',                      'en' => ':count records'],

            // admin edit labels
            'admin.edit_location'           => ['az' => 'Yeri düzəliş et',                 'en' => 'Edit Location'],
            'admin.edit_phone_code'         => ['az' => 'Telefon kodunu düzəliş et',       'en' => 'Edit Phone Code'],

            // ── location picker ───────────────────────────────────────────────
            'label.set_location'        => ['az' => 'Yer seçin',                          'en' => 'Set location'],
            'label.location_set'        => ['az' => 'Yer seçildi',                        'en' => 'Location set'],
            'label.choose_location'     => ['az' => 'Yerini seç',                         'en' => 'Choose your location'],
            'label.change_location'     => ['az' => 'Yeri dəyiş',                         'en' => 'Change location'],
            'label.search_address'      => ['az' => 'Ünvan axtar...',                     'en' => 'Search address...'],
            'label.use_my_location'     => ['az' => 'Mənim yerim',                        'en' => 'Use my location'],
            'label.no_results'          => ['az' => 'Nəticə tapılmadı',                   'en' => 'No results found'],
            'button.close'              => ['az' => 'Bağla',                               'en' => 'Close'],
            'button.clear_location'     => ['az' => 'Yeri sil',                           'en' => 'Clear location'],
            'button.confirm_location'   => ['az' => 'Yer seç',                            'en' => 'Confirm location'],

            // ── store discovery headings ──────────────────────────────────────
            'heading.nearby_stores'        => ['az' => 'Yaxınlıqdakı Mağazalar',          'en' => 'Popular Stores Near You'],
            'heading.nearby_stores_desc'   => ['az' => '50 km ərzindəki aktiv mağazalar', 'en' => 'Active stores within 50 km of your location'],
            'heading.no_stores_in_city'    => ['az' => 'Seçdiyiniz şəhərdə qeydiyyatdan keçmiş mağaza yoxdur. Aşağıda ölkənizdəki mağazalar göstərilir.',
                                               'en' => 'There are no registered stores available in your selected city. Showing stores from your country instead.'],
        ];

        foreach ($data as $fullKey => $translations) {
            [$group, $key] = explode('.', $fullKey, 2);

            foreach ($translations as $locale => $value) {
                Translation::updateOrCreate(
                    ['locale_code' => $locale, 'group' => $group, 'key' => $key],
                    ['value' => $value, 'is_active' => true]
                );
            }
        }

        // Clear translation cache so fresh data is served immediately
        app(TranslationService::class)->clearCache();

        $this->command->info('✓ Translations seeded: ' . (count($data) * 2) . ' entries (az + en)');
    }
}
