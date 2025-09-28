<?php

namespace Tigusigalpa\YandexGPT\Tests\Laravel;

use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Tests\TestCase;
use Tigusigalpa\YandexGPT\YandexGPTClient;

class YandexGPTServiceProviderTest extends TestCase
{
    public function testServiceProviderRegistersClient()
    {
        $this->app['config']->set('yandexgpt.oauth_token', 'test_token');
        $this->app['config']->set('yandexgpt.folder_id', 'test_folder');

        $client = $this->app->make('yandexgpt');

        $this->assertInstanceOf(YandexGPTClient::class, $client);
    }

    public function testFacadeResolves()
    {
        $this->app['config']->set('yandexgpt.oauth_token', 'test_token');
        $this->app['config']->set('yandexgpt.folder_id', 'test_folder');

        $this->assertInstanceOf(YandexGPTClient::class, YandexGPT::getFacadeRoot());
    }

    public function testConfigurationIsPublished()
    {
        $this->artisan('vendor:publish', ['--tag' => 'yandexgpt-config'])
            ->assertExitCode(0);
    }
}