<?php

namespace Tigusigalpa\YandexGPT\Laravel;

use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Tigusigalpa\YandexGPT\YandexGPTClient;

class YandexGPTServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/yandexgpt.php',
            'yandexgpt'
        );

        $this->app->singleton('yandexgpt', function ($app) {
            $config = $app['config']['yandexgpt'];

            // Configuration validation
            if (empty($config['oauth_token'])) {
                throw new InvalidArgumentException('YandexGPT OAuth token is not configured. Add YANDEX_GPT_OAUTH_TOKEN to .env file');
            }

            if (empty($config['folder_id'])) {
                throw new InvalidArgumentException('YandexGPT Folder ID is not configured. Add YANDEX_GPT_FOLDER_ID to .env file');
            }

            return new YandexGPTClient(
                $config['oauth_token'],
                $config['folder_id']
            );
        });

        $this->app->alias('yandexgpt', YandexGPTClient::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/yandexgpt.php' => config_path('yandexgpt.php'),
            ], 'yandexgpt-config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['yandexgpt', YandexGPTClient::class];
    }
}
