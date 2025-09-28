<?php

namespace Tigusigalpa\YandexGPT\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Tigusigalpa\YandexGPT\Exceptions\AuthenticationException;
use Tigusigalpa\YandexGPT\YandexGPTClient;

class OAuthTokenManager
{
    private Client $httpClient;
    private string $oauthToken;

    public function __construct(string $oauthToken, ?Client $httpClient = null)
    {
        $this->oauthToken = $oauthToken;
        $this->httpClient = $httpClient ?? new Client();
    }

    /**
     * Create folder in cloud
     *
     * @param  string  $iamToken
     * @param  string  $cloudId
     * @param  string  $folderName
     * @param  string|null  $description
     * @return array
     * @throws AuthenticationException
     */
    public function createFolder(string $iamToken, string $cloudId, string $folderName, ?string $description = null): array
    {
        try {
            $response = $this->httpClient->post(YandexGPTClient::FOLDERS_ENDPOINT, [
                'json' => [
                    'cloudId' => $cloudId,
                    'name' => $folderName,
                    'description' => $description ?? '',
                ],
                'headers' => [
                    'Authorization' => 'Bearer '.$iamToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new AuthenticationException('Error creating folder: '.$e->getMessage());
        }
    }

    /**
     * Assign role to user
     *
     * @param  string  $iamToken
     * @param  string  $folderId
     * @param  string  $userAccountId
     * @param  string  $role
     * @return array
     * @throws AuthenticationException
     */
    public function assignRole(
        string $iamToken,
        string $folderId,
        string $userAccountId,
        string $role = 'ai.languageModels.user'
    ): array {
        try {
            $response =
                $this->httpClient->post(YandexGPTClient::FOLDERS_ENDPOINT."/{$folderId}:setAccessBindings",
                    [
                        'json' => [
                            'accessBindings' => [
                                [
                                    'roleId' => $role,
                                    'subject' => [
                                        'id' => $userAccountId,
                                        'type' => 'userAccount',
                                    ],
                                ],
                            ],
                        ],
                        'headers' => [
                            'Authorization' => 'Bearer '.$iamToken,
                            'Content-Type' => 'application/json',
                        ],
                    ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new AuthenticationException('Error assigning role: '.$e->getMessage());
        }
    }

    /**
     * Get list of clouds (public method for README compatibility)
     *
     * @return array
     * @throws AuthenticationException
     */
    public function listClouds(): array
    {
        $iamToken = $this->getIamToken();
        return $this->getClouds($iamToken);
    }

    /**
     * Get IAM token using OAuth token
     *
     * @return string
     * @throws AuthenticationException
     */
    public function getIamToken(): string
    {
        try {
            $response = $this->httpClient->post(YandexGPTClient::IAM_TOKEN_ENDPOINT, [
                'json' => [
                    'yandexPassportOauthToken' => $this->oauthToken,
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['iamToken'])) {
                throw new AuthenticationException('Failed to get IAM token');
            }

            return $data['iamToken'];
        } catch (GuzzleException $e) {
            throw new AuthenticationException('Error getting IAM token: '.$e->getMessage());
        }
    }

    /**
     * Get list of clouds
     *
     * @param  string  $iamToken
     * @return array
     * @throws AuthenticationException
     */
    public function getClouds(string $iamToken): array
    {
        try {
            $response = $this->httpClient->get(YandexGPTClient::CLOUDS_ENDPOINT, [
                'headers' => [
                    'Authorization' => 'Bearer '.$iamToken,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['clouds'] ?? [];
        } catch (GuzzleException $e) {
            throw new AuthenticationException('Error getting clouds list: '.$e->getMessage());
        }
    }

    /**
     * Get list of folders in cloud (public method for README compatibility)
     *
     * @param  string  $cloudId
     * @return array
     * @throws AuthenticationException
     */
    public function listFolders(string $cloudId): array
    {
        $iamToken = $this->getIamToken();
        return $this->getFolders($iamToken, $cloudId);
    }

    /**
     * Get list of folders in cloud
     *
     * @param  string  $iamToken
     * @param  string  $cloudId
     * @return array
     * @throws AuthenticationException
     */
    public function getFolders(string $iamToken, string $cloudId): array
    {
        try {
            $response = $this->httpClient->get(YandexGPTClient::FOLDERS_ENDPOINT, [
                'query' => [
                    'cloudId' => $cloudId,
                ],
                'headers' => [
                    'Authorization' => 'Bearer '.$iamToken,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['folders'] ?? [];
        } catch (GuzzleException $e) {
            throw new AuthenticationException('Error getting folders list: '.$e->getMessage());
        }
    }

}
