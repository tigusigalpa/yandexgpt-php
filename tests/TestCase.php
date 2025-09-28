<?php

namespace Tigusigalpa\YandexGPT\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Tigusigalpa\YandexGPT\Laravel\YandexGPTServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            YandexGPTServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'YandexGPT' => \Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT::class,
        ];
    }
}