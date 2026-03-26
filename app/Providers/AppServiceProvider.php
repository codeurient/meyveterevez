<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Locale;
use App\Services\TranslationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind TranslationService as a singleton — one instance per request
        $this->app->singleton(TranslationService::class);
    }

    public function boot(): void
    {
        // Prevent lazy loading in non-production — catches N+1 queries early
        Model::preventLazyLoading(! app()->isProduction());

        // Share active locales with ALL views (used by language switcher in layout)
        View::composer('*', function ($view) {
            try {
                $view->with('activeLocales', Locale::allActive());
                $view->with('currentLocale', app()->getLocale());
            } catch (\Throwable) {
                // DB not yet migrated — share empty collection
                $view->with('activeLocales', collect());
                $view->with('currentLocale', 'az');
            }
        });
    }
}
