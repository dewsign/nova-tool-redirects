<?php

namespace Dewsign\NovaToolRedirects\Providers;

use Laravel\Nova\Nova;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Dewsign\NovaToolRedirects\Nova\Redirect;
use Spatie\MissingPageRedirector\RedirectsMissingPages;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->bootViews();
        $this->bootAssets();
        $this->bootCommands();
        $this->publishDatabaseFiles();
        $this->publishConfig();
        $this->loadTranslations();

        Nova::resources([
            Redirect::class,
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigs();

        collect(config('nova-tool-redirects.middlewareGroups', []))->each(function ($group) {
            $router = $this->app['router'];
            $router->pushMiddlewareToGroup($group, RedirectsMissingPages::class);
        });
    }

    /**
     * Register the artisan packages' terminal commands
     *
     * @return void
     */
    private function bootCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                // MyCommand::class,
            ]);
        }
    }

    /**
     * Load custom views
     *
     * @return void
     */
    private function bootViews()
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'dewsign');
        $this->publishes([
            __DIR__.'/../Resources/views' => resource_path('views/vendor/dewsign'),
        ]);
    }

    /**
     * Define publishable assets
     *
     * @return void
     */
    private function bootAssets()
    {
        $this->publishes([
            __DIR__.'/../Resources/assets/js' => resource_path('assets/js/vendor/dewsign'),
        ], 'js');
    }

    private function publishDatabaseFiles()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');

        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(
            __DIR__ . '/../Database/factories'
        );

        $this->publishes([
            __DIR__ . '/../Database/factories' => base_path('database/factories')
        ], 'factories');

        $this->publishes([
            __DIR__ . '/../Database/migrations' => base_path('database/migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../Database/seeds' => base_path('database/seeds')
        ], 'seeds');
    }

    public function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/nova-tool-redirects.php' => config_path('nova-tool-redirects.php'),
        ], 'config');
    }

    public function mergeConfigs()
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/missing-page-redirector.php', 'missing-page-redirector');
        $this->mergeConfigFrom(__DIR__.'/../Config/nova-tool-redirects.php', 'nova-tool-redirects');
    }

    private function loadTranslations()
    {
        $this->loadJSONTranslationsFrom(__DIR__.'/../Resources/lang', 'novatoolredirects');
    }
}
