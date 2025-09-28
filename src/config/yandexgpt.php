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
    | YandexGPT Folder ID
    |--------------------------------------------------------------------------
    |
    | Catalog ID at Yandex Cloud where requests will be executed.
    | The folder must have ai.languageModels.user permissions.
    |
    */
    'folder_id' => env('YANDEX_GPT_FOLDER_ID'),

    /*
    |--------------------------------------------------------------------------
    | Default Model
    |--------------------------------------------------------------------------
    |
    | YandexGPT default model for text generation.
    |
    */
    'default_model' => env('YANDEX_GPT_DEFAULT_MODEL', 'yandexgpt-lite'),

    /*
    |--------------------------------------------------------------------------
    | Temperature
    |--------------------------------------------------------------------------
    |
    | Temperature for text generation (0.0 - 1.0).
    | Higher values make responses more creative.
    |
    */
    'temperature' => (float) env('YANDEX_GPT_TEMPERATURE', 0.6),

    /*
    |--------------------------------------------------------------------------
    | Max Tokens
    |--------------------------------------------------------------------------
    |
    | Maximum number of tokens in the response.
    |
    */
    'max_tokens' => (int) env('YANDEX_GPT_MAX_TOKENS', 2000),
];