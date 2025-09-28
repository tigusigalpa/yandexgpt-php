<?php

namespace Tigusigalpa\YandexGPT\Models;

class YandexGPTModel
{
    // Base YandexGPT models
    public const YANDEX_GPT_LITE = 'yandexgpt-lite';
    public const YANDEX_GPT = 'yandexgpt';
    public const YANDEX_GPT_PRO = 'yandexgpt-pro';
    
    // Models with version specification
    public const YANDEX_GPT_LITE_LATEST = 'yandexgpt-lite/latest';
    public const YANDEX_GPT_LATEST = 'yandexgpt/latest';
    public const YANDEX_GPT_PRO_LATEST = 'yandexgpt-pro/latest';
    
    // Models with specific versions
    public const YANDEX_GPT_LITE_RC = 'yandexgpt-lite/rc';
    public const YANDEX_GPT_RC = 'yandexgpt/rc';
    public const YANDEX_GPT_PRO_RC = 'yandexgpt-pro/rc';

    // Specialized models
    public const YANDEX_GPT_32K = 'yandexgpt-32k';
    public const YANDEX_GPT_32K_LATEST = 'yandexgpt-32k/latest';

    /**
     * Get all available models
     *
     * @return array
     */
    public static function getAllModels(): array
    {
        return [
            self::YANDEX_GPT_LITE,
            self::YANDEX_GPT,
            self::YANDEX_GPT_PRO,
            self::YANDEX_GPT_LITE_LATEST,
            self::YANDEX_GPT_LATEST,
            self::YANDEX_GPT_PRO_LATEST,
            self::YANDEX_GPT_LITE_RC,
            self::YANDEX_GPT_RC,
            self::YANDEX_GPT_PRO_RC,
            self::YANDEX_GPT_32K,
            self::YANDEX_GPT_32K_LATEST,
        ];
    }

    /**
     * Get model descriptions
     *
     * @return array
     */
    public static function getModelDescriptions(): array
    {
        return [
            self::YANDEX_GPT_LITE => 'Lightweight version of YandexGPT for simple tasks',
            self::YANDEX_GPT => 'Standard YandexGPT model',
            self::YANDEX_GPT_PRO => 'Advanced version of YandexGPT with enhanced capabilities',
            self::YANDEX_GPT_32K => 'YandexGPT model with extended context up to 32K tokens',
        ];
    }

    /**
     * Check if model is valid
     *
     * @param string $model
     * @return bool
     */
    public static function isValidModel(string $model): bool
    {
        return in_array($model, self::getAllModels());
    }

    /**
     * Get model URI for API
     *
     * @param string $model
     * @param string $folderId
     * @return string
     */
    public static function getModelUri(string $model, string $folderId): string
    {
        return "gpt://{$folderId}/{$model}";
    }
}