<?php

namespace Tigusigalpa\YandexGPT;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;
use Tigusigalpa\YandexGPT\Auth\OAuthTokenManager;
use Tigusigalpa\YandexGPT\Exceptions\ApiException;
use Tigusigalpa\YandexGPT\Exceptions\AuthenticationException;
use Tigusigalpa\YandexGPT\Models\YandexARTModel;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

class YandexGPTClient
{
    const FOLDERS_ENDPOINT = 'https://resource-manager.api.cloud.yandex.net/resource-manager/v1/folders';
    const IAM_TOKEN_ENDPOINT = 'https://iam.api.cloud.yandex.net/iam/v1/tokens';
    const CLOUDS_ENDPOINT = 'https://resource-manager.api.cloud.yandex.net/resource-manager/v1/clouds';
    const COMPLETION_ENDPOINT = 'https://llm.api.cloud.yandex.net/foundationModels/v1/completion';
    const IMAGE_GENERATION_ASYNC_ENDPOINT = 'https://llm.api.cloud.yandex.net/foundationModels/v1/imageGenerationAsync';
    const OPERATIONS_ENDPOINT = 'https://operation.api.cloud.yandex.net/operations';
    private Client $httpClient;
    private OAuthTokenManager $authManager;
    private string $folderId;
    private ?string $iamToken = null;
    private ?int $iamTokenExpiry = null;

    public function __construct(string $oauthToken, string $folderId, ?Client $httpClient = null)
    {
        // Validate required parameters
        if (empty($oauthToken)) {
            throw new AuthenticationException('OAuth token cannot be empty');
        }

        if (empty($folderId)) {
            throw new AuthenticationException('Folder ID cannot be empty');
        }

        $this->httpClient = $httpClient ?? new Client();
        $this->authManager = new OAuthTokenManager($oauthToken, $this->httpClient);
        $this->folderId = $folderId;
    }

    /**
     * Send request to YandexGPT
     *
     * @param  string  $prompt
     * @param  string  $model
     * @param  array  $options
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function generateText(string $prompt, string $model = YandexGPTModel::YANDEX_GPT_LITE, array $options = []): array
    {
        if (!YandexGPTModel::isValidModel($model)) {
            throw new ApiException("Invalid model: {$model}");
        }

        $iamToken = $this->getValidIamToken();
        $modelUri = YandexGPTModel::getModelUri($model, $this->folderId);

        $requestData = [
            'modelUri' => $modelUri,
            'completionOptions' => array_merge([
                'stream' => false,
                'temperature' => 0.6,
                'maxTokens' => 2000,
            ], $options['completionOptions'] ?? []),
            'messages' => [
                [
                    'role' => 'user',
                    'text' => $prompt,
                ],
            ],
        ];

        try {
            $response = $this->httpClient->post(self::COMPLETION_ENDPOINT, [
                'json' => $requestData,
                'headers' => [
                    'Authorization' => 'Bearer '.$iamToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            if ($statusCode !== 200) {
                $errorData = json_decode($responseBody, true);
                $errorMessage = $errorData['message'] ?? 'Unknown API error';
                throw new ApiException("YandexGPT API error (code {$statusCode}): {$errorMessage}");
            }

            $data = json_decode($responseBody, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ApiException('Error decoding JSON response from YandexGPT');
            }

            return $data;
        } catch (GuzzleException $e) {
            throw new ApiException('Error sending request to YandexGPT: '.$e->getMessage());
        }
    }

    /**
     * Get valid IAM token (refresh if necessary)
     *
     * @return string
     * @throws AuthenticationException
     */
    private function getValidIamToken(): string
    {
        // Проверяем, нужно ли обновить токен (токены действуют 12 часов)
        if ($this->iamToken === null || $this->iamTokenExpiry === null || time() >= $this->iamTokenExpiry) {
            $this->iamToken = $this->authManager->getIamToken();
            $this->iamTokenExpiry = time() + (12 * 60 * 60) - 300; // 12 часов минус 5 минут запаса
        }

        return $this->iamToken;
    }

    /**
     * Send request with dialog (multiple messages)
     *
     * @param  array  $messages
     * @param  string  $model
     * @param  array  $options
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function generateFromMessages(
        array $messages,
        string $model = YandexGPTModel::YANDEX_GPT_LITE,
        array $options = []
    ): array {
        if (!YandexGPTModel::isValidModel($model)) {
            throw new ApiException("Invalid model: {$model}");
        }

        $iamToken = $this->getValidIamToken();
        $modelUri = YandexGPTModel::getModelUri($model, $this->folderId);

        $requestData = [
            'modelUri' => $modelUri,
            'completionOptions' => array_merge([
                'stream' => false,
                'temperature' => 0.6,
                'maxTokens' => 2000,
            ], $options['completionOptions'] ?? []),
            'messages' => $messages,
        ];

        try {
            $response = $this->httpClient->post(self::COMPLETION_ENDPOINT, [
                'json' => $requestData,
                'headers' => [
                    'Authorization' => 'Bearer '.$iamToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            if ($statusCode !== 200) {
                $errorData = json_decode($responseBody, true);
                $errorMessage = $errorData['message'] ?? 'Unknown API error';
                throw new ApiException("YandexGPT API error (code {$statusCode}): {$errorMessage}");
            }

            $data = json_decode($responseBody, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ApiException('Error decoding JSON response from YandexGPT');
            }

            return $data;
        } catch (GuzzleException $e) {
            throw new ApiException('Error sending request to YandexGPT: '.$e->getMessage());
        }
    }

    /**
     * Get information about available models
     *
     * @return array
     */
    public function getAvailableModels(): array
    {
        return YandexGPTModel::getAllModels();
    }

    /**
     * Get model descriptions
     *
     * @return array
     */
    public function getModelDescriptions(): array
    {
        return YandexGPTModel::getModelDescriptions();
    }

    /**
     * Get authentication manager
     *
     * @return OAuthTokenManager
     */
    public function getAuthManager(): OAuthTokenManager
    {
        return $this->authManager;
    }

    /**
     * Get current folder ID
     *
     * @return string
     */
    public function getFolderId(): string
    {
        return $this->folderId;
    }

    /**
     * Set new folder ID
     *
     * @param  string  $folderId
     * @return void
     */
    public function setFolderId(string $folderId): void
    {
        $this->folderId = $folderId;
    }

    /**
     * Synchronous image generation (wrapper around generateImageAsync + polling)
     * Returns array with operationId and Base64 image string.
     *
     * @param  array|string  $messages
     * @param  array  $generationOptions
     * @param  string|null  $catalogId
     * @param  int  $pollIntervalSeconds
     * @param  int  $maxWaitSeconds
     * @return array{operationId:string,image_base64:string}
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function generateImage(
        array|string $messages,
        array $generationOptions = [],
        ?string $catalogId = null,
        int $pollIntervalSeconds = 2,
        int $maxWaitSeconds = 600
    ): array {
        $operation = $this->generateImageAsync($messages, $generationOptions, $catalogId);
        $operationId = $operation['id'] ?? null;

        if (!$operationId) {
            throw new ApiException('Operation ID not found in YandexART response');
        }

        $elapsed = 0;
        while ($elapsed < $maxWaitSeconds) {
            sleep($pollIntervalSeconds);
            $elapsed += $pollIntervalSeconds;

            $op = $this->getOperation($operationId);
            $done = $op['done'] ?? false;

            if ($done) {
                if (!empty($op['error'])) {
                    $message = $op['error']['message'] ?? 'Unknown error';
                    throw new ApiException('YandexART operation error: '.$message);
                }

                $imageBase64 = $op['response']['image'] ?? null;
                if (!$imageBase64) {
                    throw new ApiException('Image data not found in YandexART operation response');
                }

                return [
                    'operationId' => $operationId,
                    'image_base64' => $imageBase64,
                ];
            }
        }

        throw new ApiException('YandexART operation timed out');
    }

    /**
     * Asynchronous image generation (YandexART)
     * Returns Operation object.
     *
     * @param  array|string  $messages
     * @param  array  $generationOptions
     * @param  string|null  $catalogId
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function generateImageAsync(array|string $messages, array $generationOptions = [], ?string $catalogId = null): array
    {
        $iamToken = $this->getValidIamToken();
        $modelUri = YandexARTModel::getModelUri($catalogId ?? $this->folderId);

        // Ensure generationOptions is encoded as an object ({}), not an array ([]), when empty
        $normalizedGenerationOptions = empty($generationOptions) ? new stdClass() : $generationOptions;

        $requestData = [
            'modelUri' => $modelUri,
            'generationOptions' => $normalizedGenerationOptions,
            'messages' => $this->normalizeArtMessages($messages),
        ];

        try {
            $response = $this->httpClient->post(self::IMAGE_GENERATION_ASYNC_ENDPOINT, [
                'json' => $requestData,
                'headers' => [
                    'Authorization' => 'Bearer '.$iamToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            if ($statusCode !== 200) {
                $errorData = json_decode($responseBody, true);
                $errorMessage = $errorData['message'] ?? 'Unknown API error';
                throw new ApiException("YandexART API error (code {$statusCode}): {$errorMessage}");
            }

            $data = json_decode($responseBody, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ApiException('Error decoding JSON response from YandexART');
            }

            return $data;
        } catch (GuzzleException $e) {
            throw new ApiException('Error sending request to YandexART: '.$e->getMessage());
        }
    }

    /**
     * Normalize messages for YandexART
     * Accepts string (single prompt) or array of strings/arrays.
     * Converts each element to ['text' => string, 'weight' => int]
     *
     * @param  array|string  $messages
     * @return array
     */
    private function normalizeArtMessages(array|string $messages): array
    {
        if (is_string($messages)) {
            return [['text' => $messages, 'weight' => 1]];
        }

        $normalized = [];
        foreach ($messages as $msg) {
            if (is_string($msg)) {
                $normalized[] = ['text' => $msg, 'weight' => 1];
            } elseif (is_array($msg)) {
                $normalized[] = [
                    'text' => $msg['text'] ?? '',
                    'weight' => $msg['weight'] ?? 1,
                ];
            }
        }

        return $normalized;
    }

    /**
     * Get status of operation by ID
     *
     * @param  string  $operationId
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function getOperation(string $operationId): array
    {
        $iamToken = $this->getValidIamToken();

        try {
            $response = $this->httpClient->get(self::OPERATIONS_ENDPOINT.'/'.$operationId, [
                'headers' => [
                    'Authorization' => 'Bearer '.$iamToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            if ($statusCode !== 200) {
                $errorData = json_decode($responseBody, true);
                $errorMessage = $errorData['message'] ?? 'Unknown API error';
                throw new ApiException("Operations API error (code {$statusCode}): {$errorMessage}");
            }

            $data = json_decode($responseBody, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ApiException('Error decoding JSON response from Operations API');
            }

            return $data;
        } catch (GuzzleException $e) {
            throw new ApiException('Error requesting operation status: '.$e->getMessage());
        }
    }
}
