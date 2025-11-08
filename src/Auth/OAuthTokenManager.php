<?php

namespace Tigusigalpa\YandexGPT\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Tigusigalpa\YandexGPT\Exceptions\AuthenticationException;
use Tigusigalpa\YandexGPT\YandexGPTClient;

class OAuthTokenManager
{
    private const USER_ACCOUNT_ENDPOINT = 'https://iam.api.cloud.yandex.net/iam/v1/yandexPassportUserAccounts:byLogin';
    private const USER_ACCOUNT_GET_ENDPOINT = 'https://iam.api.cloud.yandex.net/iam/v1/userAccounts';
    
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
     * Assign role to folder
     *
     * @param  string  $iamToken
     * @param  string  $folderId
     * @param  string  $subjectId  Subject ID (user or service account)
     * @param  string  $role  Role ID (e.g., 'ai.languageModels.user', 'editor')
     * @param  string  $subjectType  Subject type: 'userAccount' or 'serviceAccount'
     * @return array
     * @throws AuthenticationException
     * @see https://yandex.cloud/en/docs/resource-manager/api-ref/Folder/updateAccessBindings
     */
    public function assignRoleToFolder(
        string $iamToken,
        string $folderId,
        string $subjectId,
        string $role = 'ai.languageModels.user',
        string $subjectType = 'userAccount'
    ): array {
        try {
            $response = $this->httpClient->post(
                YandexGPTClient::FOLDERS_ENDPOINT."/{$folderId}:updateAccessBindings",
                [
                    'json' => [
                        'accessBindingDeltas' => [
                            [
                                'action' => 'ADD',
                                'accessBinding' => [
                                    'roleId' => $role,
                                    'subject' => [
                                        'id' => $subjectId,
                                        'type' => $subjectType,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer '.$iamToken,
                        'Content-Type' => 'application/json',
                    ],
                ]
            );

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new AuthenticationException('Error assigning role to folder: '.$e->getMessage());
        }
    }

    /**
     * Assign role to cloud
     *
     * @param  string  $iamToken
     * @param  string  $cloudId
     * @param  string  $subjectId  Subject ID (user or service account)
     * @param  string  $role  Role ID (e.g., 'editor', 'viewer')
     * @param  string  $subjectType  Subject type: 'userAccount' or 'serviceAccount'
     * @return array
     * @throws AuthenticationException
     * @see https://yandex.cloud/en/docs/resource-manager/api-ref/Cloud/updateAccessBindings
     */
    public function assignRoleToCloud(
        string $iamToken,
        string $cloudId,
        string $subjectId,
        string $role = 'viewer',
        string $subjectType = 'userAccount'
    ): array {
        try {
            $response = $this->httpClient->post(
                YandexGPTClient::CLOUDS_ENDPOINT."/{$cloudId}:updateAccessBindings",
                [
                    'json' => [
                        'accessBindingDeltas' => [
                            [
                                'action' => 'ADD',
                                'accessBinding' => [
                                    'roleId' => $role,
                                    'subject' => [
                                        'id' => $subjectId,
                                        'type' => $subjectType,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer '.$iamToken,
                        'Content-Type' => 'application/json',
                    ],
                ]
            );

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new AuthenticationException('Error assigning role to cloud: '.$e->getMessage());
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

    /**
     * Get user ID (Subject ID) by login - convenience method
     *
     * @param  string  $login  Yandex Passport user login
     * @return string User Subject ID
     * @throws AuthenticationException
     */
    public function getUserIdByLogin(string $login): string
    {
        $user = $this->getUserByLogin($login);
        return $user['id'];
    }

    /**
     * Get user account information by login
     *
     * @param  string  $login  Yandex Passport user login
     * @return array User account data including 'id' (Subject ID)
     * @throws AuthenticationException
     * @see https://yandex.cloud/en/docs/iam/api-ref/YandexPassportUserAccount/getByLogin
     */
    public function getUserByLogin(string $login): array
    {
        $iamToken = $this->getIamToken();

        try {
            $response = $this->httpClient->get(self::USER_ACCOUNT_ENDPOINT, [
                'query' => [
                    'login' => $login,
                ],
                'headers' => [
                    'Authorization' => 'Bearer '.$iamToken,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['id'])) {
                throw new AuthenticationException('User account response does not contain id field');
            }

            return $data;
        } catch (GuzzleException $e) {
            throw new AuthenticationException('Error getting user by login: '.$e->getMessage());
        }
    }

    /**
     * Get user account information by UserAccountId
     *
     * @param  string  $userAccountId  User Account ID (Subject ID)
     * @return array User account data
     * @throws AuthenticationException
     * @see https://yandex.cloud/en/docs/iam/api-ref/UserAccount/get
     */
    public function getUserAccount(string $userAccountId): array
    {
        $iamToken = $this->getIamToken();

        try {
            $response = $this->httpClient->get(self::USER_ACCOUNT_GET_ENDPOINT.'/'.$userAccountId, [
                'headers' => [
                    'Authorization' => 'Bearer '.$iamToken,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['id'])) {
                throw new AuthenticationException('User account response does not contain id field');
            }

            return $data;
        } catch (GuzzleException $e) {
            throw new AuthenticationException('Error getting user account: '.$e->getMessage());
        }
    }

}
