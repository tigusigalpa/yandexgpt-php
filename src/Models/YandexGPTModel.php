<?php

namespace Tigusigalpa\YandexGPT\Models;

class YandexGPTModel
{
    // Base YandexGPT models
    // @link https://yandex.cloud/ru/docs/ai-studio/concepts/generation/models
    public const YANDEX_GPT_LITE = 'yandexgpt-lite';
    public const YANDEX_GPT = 'yandexgpt';

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
        ];
    }

    /**
     * Check if model is valid
     *
     * @param  string  $model
     * @return bool
     */
    public static function isValidModel(string $model): bool
    {
        return in_array($model, self::getAllModels());
    }

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
        ];
    }

    /**
     * Get model URI for API
     *
     * @param  string  $model
     * @param  string  $folderId
     * @return string
     */
    public static function getModelUri(string $model, string $folderId): string
    {
        return "gpt://{$folderId}/{$model}";
    }
}
