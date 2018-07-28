<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\Layouts\ResourcesComposer;
use App\Http\ViewComposers\Layouts\AppComposer;
use App\Http\ViewComposers\Layouts\Middle\SearchComposer;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.resources', ResourcesComposer::class);
        View::composer('layouts.app', AppComposer::class);
        View::composer('layouts.middle.search', SearchComposer::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
