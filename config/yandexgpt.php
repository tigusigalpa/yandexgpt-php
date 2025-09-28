<?php

return [
    /*
    |--------------------------------------------------------------------------
    | YandexGPT OAuth Token
    |--------------------------------------------------------------------------
    |
    | OAuth token for accessing Yandex Cloud API.
    | Can be obtained from:
    | https://oauth.yandex.ru/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb
    |
    */
    'oauth_token' => env('YANDEX_GPT_OAUTH_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Folder ID
    |--------------------------------------------------------------------------
    |
    | Folder ID in Yandex Cloud where requests will be executed.
    | The folder must have ai.languageModels.user permissions.
    |
    */
    'folder_id' => env('YANDEX_GPT_FOLDER_ID'),

    /*
    |--------------------------------------------------------------------------
    | Default Model
    |--------------------------------------------------------------------------
    |
    | Default YandexGPT model for text generation.
    | Available models:
    | - yandexgpt-lite (fast and economical)
    | - yandexgpt (standard)
    | - yandexgpt-pro (advanced)
    | - yandexgpt-32k (with extended context)
    |
    */
    'default_model' => env('YANDEX_GPT_DEFAULT_MODEL', 'yandexgpt-lite'),

    /*
    |--------------------------------------------------------------------------
    | Default Completion Options
    |--------------------------------------------------------------------------
    |
    | Default generation parameters.
    |
    */
    'default_options' => [
        'temperature' => (float) env('YANDEX_GPT_TEMPERATURE', 0.6),
        'maxTokens' => (int) env('YANDEX_GPT_MAX_TOKENS', 2000),
        'stream' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Options
    |--------------------------------------------------------------------------
    |
    | HTTP client settings for API requests.
    |
    */
    'http_options' => [
        'timeout' => (int) env('YANDEX_GPT_TIMEOUT', 30),
        'connect_timeout' => (int) env('YANDEX_GPT_CONNECT_TIMEOUT', 10),
    ],
];