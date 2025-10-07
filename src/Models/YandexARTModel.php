<?php

namespace Tigusigalpa\YandexGPT\Models;

class YandexARTModel
{
    /**
     * Latest YandexART model identifier segment
     */
    public const YANDEX_ART_LATEST = 'yandex-art/latest';

    /**
     * Build modelUri for YandexART
     *
     * @param string $catalogId Folder/Catalog ID that has ai.imageGeneration.user role
     * @return string
     */
    public static function getModelUri(string $catalogId): string
    {
        return "art://{$catalogId}/" . self::YANDEX_ART_LATEST;
    }
}