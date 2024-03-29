<?php

namespace Kovyakin\VueTable;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Kovyakin\VueTable\Console\Commands\InstallCommand;

class VueTableServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
//        Blade::componentNamespace('Kovyakin\\View\\Components','table');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'kovyakin');
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'kovyakin');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'kovyakin');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
            $this->commands([
                InstallCommand::class,
//                NetworkCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/vue-table.php', 'vue-table');

        // Register the service the package provides.
        $this->app->singleton('vue-table', function ($app) {
            return new VueTable;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['vue-table'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/vue-table.php' => config_path('vue-table.php'),
        ], 'vue-table.config');

        $this->publishes([
            __DIR__ . '/../public' => public_path('kovyakin/vue-table'),
        ], 'public');
        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/kovyakin'),
        ], 'vue-table.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/kovyakin'),
        ], 'vue-table.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/kovyakin'),
        ], 'vue-table.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
