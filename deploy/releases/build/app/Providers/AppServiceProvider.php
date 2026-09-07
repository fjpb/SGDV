<?php

namespace App\Providers;

use App\Models\Document;
use App\Observers\DocumentObserver;
use App\View\Composers\NavbarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Document::observe(DocumentObserver::class);

        View::composer(
            'components.layout.navbar',
            NavbarComposer::class
        );
    }
}
