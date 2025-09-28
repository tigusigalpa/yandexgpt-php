<?php

namespace Tigusigalpa\YandexGPT;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Tigusigalpa\YandexGPT\Auth\OAuthTokenManager;
use Tigusigalpa\YandexGPT\Exceptions\ApiException;
use Tigusigalpa\YandexGPT\Exceptions\AuthenticationException;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

class YandexGPTClient
{
    const FOLDERS_ENDPOINT = 'https://resource-manager.api.cloud.yandex.net/resource-manager/v1/folders';
    const IAM_TOKEN_ENDPOINT = 'https://iam.api.cloud.yandex.net/iam/v1/tokens';
    const CLOUDS_ENDPOINT = 'https://resource-manager.api.cloud.yandex.net/resource-manager/v1/clouds';
    const COMPLETION_ENDPOINT = 'https://llm.api.cloud.yandex.net/foundationModels/v1/completion';
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
}
