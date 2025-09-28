<?php

namespace Tigusigalpa\YandexGPT\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array generateText(string $prompt, string $model = 'yandexgpt-lite', array $options = [])
 * @method static array generateFromMessages(array $messages, string $model = 'yandexgpt-lite', array $options = [])
 * @method static array getAvailableModels()
 * @method static array getModelDescriptions()
 * @method static \Tigusigalpa\YandexGPT\Auth\OAuthTokenManager getAuthManager()
 * @method static void setFolderId(string $folderId)
 * @method static string getFolderId()
 *
 * @see \Tigusigalpa\YandexGPT\YandexGPTClient
 */
class YandexGPT extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'yandexgpt';
    }
}