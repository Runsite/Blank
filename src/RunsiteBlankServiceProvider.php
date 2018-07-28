<?php

namespace Runsite\Blank;

use Illuminate\Support\ServiceProvider;

class RunsiteBlankServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/resources/langs', 'runsite-blank');

        $this->publishes([
            __DIR__.'/../publish' => base_path(),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Console\Commands\BlankCommand::class,
        ]);
    }
}
