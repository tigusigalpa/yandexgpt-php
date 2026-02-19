<?php

namespace Tigusigalpa\YandexGPT\Conversations;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Tigusigalpa\YandexCloudClient\YandexCloudClient;
use Tigusigalpa\YandexGPT\Exceptions\ApiException;
use Tigusigalpa\YandexGPT\Exceptions\AuthenticationException;

class ConversationsClient
{
    const BASE_URL = 'https://ai.api.cloud.yandex.net/v1/conversations';

    private Client $httpClient;
    private YandexCloudClient $cloudClient;

    public function __construct(YandexCloudClient $cloudClient, Client $httpClient)
    {
        $this->cloudClient = $cloudClient;
        $this->httpClient = $httpClient;
    }

    /**
     * Create a new conversation
     *
     * @link https://yandex.cloud/ru/docs/ai-studio/conversations/createConversation
     *
     * @param  array|null  $metadata  Set of up to 16 key-value pairs (keys max 64 chars, values max 512 chars)
     * @param  array|null  $items  Initial conversation items
     * @return array{id: string, object: string, metadata: mixed, created_at: int}
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function create(?array $metadata = null, ?array $items = null): array
    {
        $body = [];

        if ($metadata !== null) {
            $body['metadata'] = $metadata;
        }

        if ($items !== null) {
            $body['items'] = $items;
        }

        return $this->sendRequest('POST', self::BASE_URL, $body);
    }

    /**
     * Retrieve a conversation by ID
     *
     * @link https://yandex.cloud/ru/docs/ai-studio/conversations/getConversation
     *
     * @param  string  $conversationId
     * @return array{id: string, object: string, metadata: mixed, created_at: int}
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function get(string $conversationId): array
    {
        return $this->sendRequest('GET', self::BASE_URL . '/' . $conversationId);
    }

    /**
     * Update a conversation
     *
     * @link https://yandex.cloud/ru/docs/ai-studio/conversations/updateConversation
     *
     * @param  string  $conversationId
     * @param  array|null  $metadata  Set of up to 16 key-value pairs
     * @return array{id: string, object: string, metadata: mixed, created_at: int}
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function update(string $conversationId, ?array $metadata = null): array
    {
        $body = [];

        if ($metadata !== null) {
            $body['metadata'] = $metadata;
        }

        return $this->sendRequest('POST', self::BASE_URL . '/' . $conversationId, $body);
    }

    /**
     * Delete a conversation
     *
     * @link https://yandex.cloud/ru/docs/ai-studio/conversations/deleteConversation
     *
     * @param  string  $conversationId
     * @return array{object: string, deleted: bool, id: string}
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function delete(string $conversationId): array
    {
        return $this->sendRequest('DELETE', self::BASE_URL . '/' . $conversationId);
    }

    /**
     * Create items in a conversation
     *
     * @link https://yandex.cloud/ru/docs/ai-studio/conversations/createConversationItems
     *
     * @param  string  $conversationId
     * @param  array  $items  Array of conversation items to create
     * @return array{object: string, data: array, has_more: bool, first_id: string, last_id: string}
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function createItems(string $conversationId, array $items): array
    {
        return $this->sendRequest(
            'POST',
            self::BASE_URL . '/' . $conversationId . '/items',
            ['items' => $items]
        );
    }

    /**
     * List items in a conversation
     *
     * @link https://yandex.cloud/ru/docs/ai-studio/conversations/listConversationItems
     *
     * @param  string  $conversationId
     * @param  int|null  $limit  Number of items to return (1-100, default 20)
     * @param  string|null  $order  Sort order: 'asc' or 'desc' (default 'desc')
     * @param  string|null  $after  Item ID for pagination (list items after this ID)
     * @return array{object: string, data: array, has_more: bool, first_id: string, last_id: string}
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function listItems(string $conversationId, ?int $limit = null, ?string $order = null, ?string $after = null): array
    {
        $query = [];

        if ($limit !== null) {
            $query['limit'] = $limit;
        }

        if ($order !== null) {
            $query['order'] = $order;
        }

        if ($after !== null) {
            $query['after'] = $after;
        }

        $url = self::BASE_URL . '/' . $conversationId . '/items';

        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        return $this->sendRequest('GET', $url);
    }

    /**
     * Retrieve a single item from a conversation
     *
     * @link https://yandex.cloud/ru/docs/ai-studio/conversations/getConversationItem
     *
     * @param  string  $conversationId
     * @param  string  $itemId
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function getItem(string $conversationId, string $itemId): array
    {
        return $this->sendRequest(
            'GET',
            self::BASE_URL . '/' . $conversationId . '/items/' . $itemId
        );
    }

    /**
     * Delete an item from a conversation
     *
     * @link https://yandex.cloud/ru/docs/ai-studio/conversations/deleteConversationItem
     *
     * @param  string  $conversationId
     * @param  string  $itemId
     * @return array{id: string, object: string, metadata: mixed, created_at: int}
     * @throws ApiException
     * @throws AuthenticationException
     */
    public function deleteItem(string $conversationId, string $itemId): array
    {
        return $this->sendRequest(
            'DELETE',
            self::BASE_URL . '/' . $conversationId . '/items/' . $itemId
        );
    }

    /**
     * Get valid IAM token
     *
     * @return string
     * @throws AuthenticationException
     */
    private function getValidIamToken(): string
    {
        return $this->cloudClient->getAuthManager()->getValidIamToken();
    }

    /**
     * Send HTTP request to the Conversations API
     *
     * @param  string  $method
     * @param  string  $url
     * @param  array|null  $body
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     */
    private function sendRequest(string $method, string $url, ?array $body = null): array
    {
        $iamToken = $this->getValidIamToken();

        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $iamToken,
                'Content-Type' => 'application/json',
            ],
        ];

        if ($body !== null && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            $options['json'] = $body;
        }

        try {
            $response = $this->httpClient->request($method, $url, $options);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            if ($statusCode !== 200) {
                $errorData = json_decode($responseBody, true);
                $errorMessage = $errorData['message'] ?? 'Unknown API error';
                throw new ApiException("Conversations API error (code {$statusCode}): {$errorMessage}");
            }

            $data = json_decode($responseBody, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ApiException('Error decoding JSON response from Conversations API');
            }

            return $data;
        } catch (GuzzleException $e) {
            throw new ApiException('Error sending request to Conversations API: ' . $e->getMessage());
        }
    }
}
