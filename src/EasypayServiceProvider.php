<?php
namespace Controlink\LaravelEasypay;

use Illuminate\Support\ServiceProvider;

class EasypayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @throws \Exception
     */
    public function boot(): void
    {
        // Check required environment variables
        $this->checkRequiredEnvironmentVariables();

        // Load migrations from the package
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        if ($this->app->runningInConsole()) {
            // Publish migrations with a custom tag 'arpoone-migrations'
            $this->publishes([
                __DIR__.'/database/migrations' => database_path('migrations'),
            ], 'easypay-migrations');

            // Publish configuration file with a custom tag 'arpoone-config'
            $this->publishes([
                __DIR__.'/config/easypay.php' => config_path('easypay.php'),
            ], 'easypay-config');
        }

        // Load routes from package
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Merge the package configuration with the application's published config
        $this->mergeConfigFrom(
            __DIR__.'/config/easypay.php', 'easypay'
        );
    }

    /**
     * Check if the required environment variables are set
     *
     * @return void
     * @throws \Exception
     */
    protected function checkRequiredEnvironmentVariables(): void
    {
        if(config('easypay.multi_tenant', false)) {
            $required = [
                'easypay.api_key' => 'EASYPAY_API_KEY',
                'easypay.account_id' => 'EASYPAY_ACCOUNT_ID',
            ];

            foreach ($required as $configKey => $envVar) {
                if (empty(config($configKey))) {
                    throw new \Exception("The environment variable $envVar is required, please add it to your .env file.");
                }
            }
        }
    }
}