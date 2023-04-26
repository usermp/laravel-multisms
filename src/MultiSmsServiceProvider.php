<?php


namespace Usermp\MultiSms;

use Illuminate\Support\ServiceProvider;

class MultiSmsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/multisms.php', 'multisms'
        );

        $this->app->singleton(MultiSms::class, function () {
            return new MultiSms();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/multisms.php' => config_path('multisms.php'),
        ] , 'config');

        // Add the package facade to the aliases array in app.php
        $this->app->alias(Facade::class, 'MultiSms');
    }
}